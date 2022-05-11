<?php

namespace App\Http\Controllers;

use App\Models\HealthCheck;
use App\Models\MedicalReport;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class HealthCheckController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('petShelter')->only('create');
        $this->middleware('volunteer')->only('edit');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->role == 'volunteer') {
            $health_checks_pending = DB::table('users')
                ->join('health_checks', 'health_checks.shelter_id', '=', 'users.id')
                ->select(['health_checks.*', 'users.name', 'users.address', 'users.photo_path', 'users.photo_title'])
                ->where([['status', '=', 'Pending'],
                         ['volunteer_id', '=', auth()->user()->id]])
                ->orderBy('health_checks.checkup_date', 'DESC')
                ->latest()->get();
            $health_checks_accepted = DB::table('users')
                ->join('health_checks', 'health_checks.shelter_id', '=', 'users.id')
                ->select(['health_checks.*', 'users.name', 'users.address', 'users.photo_path', 'users.photo_title'])
                ->where([['status', '=', 'Accepted'],
                    ['volunteer_id', '=', auth()->user()->id]])
                ->orderBy('health_checks.checkup_date', 'DESC')
                ->latest()->get();
            $health_checks_examined = $this->filterHealthCheck($health_checks_accepted, 'examined');
            $health_checks_completed = $this->filterHealthCheck($health_checks_accepted, 'completed');
            return view('volunteer.view-health-checks',
                compact('health_checks_pending', 'health_checks_examined',
                    'health_checks_completed'));
        } else {
            return abort(404);
        }
    }

    private function filterHealthCheck($health_checks, $param) : array {
        $health_checks_new = array();
        $medical_reports = DB::table('medical_reports')->get();
        foreach ($health_checks as $check) {
            $contain = false;
            foreach ($medical_reports as $report) {
                if($check->id != $report->health_check_id) {
                    $contain = false;
                } else {
                    $contain = true; break;
                }
            }
            if ($param == 'examined' && !$contain) {
                $health_checks_new[] = $check;
            } else if ($param == 'completed' && $contain) {
                $health_checks_new[] = $check;
            }
        }
        return $health_checks_new;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->role == 'pet_shelter') {
            $total_volunteer = DB::table('users')
                                ->where('role', '=', 'volunteer')
                                ->count();
            $filter_pets1 = DB::table('pets')
                                ->where('shelter_id', '=', auth()->user()->id)->get();
            $petClaims = DB::table('lost_pet_claims')->get();
            $petAdopt = DB::table('adoptions')->get();
            $filter_pets2 = PetController::validatePets($filter_pets1, $petClaims);
            $total_pet_owned = PetController::validatePets($filter_pets2, $petAdopt);

            return view('pet_shelter.req-volunteer-form', compact('total_volunteer', 'total_pet_owned'));
        } else {
            return abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'volunteer_id' => 'required',
            'pet_id' => 'required',
            'checkup_date' => 'required',
            'description' => ['required', 'string', 'max:500']
        ]);

        HealthCheck::create([
            'shelter_id' => auth()->user()->id,
            'volunteer_id' => Crypt::decrypt($request['volunteer_id']),
            'pet_id' => Crypt::decrypt($request['pet_id']),
            'checkup_date' => $request['checkup_date'],
            'description' => $request['description']
        ]);

        return redirect()->route('users.show',
            Crypt::decrypt($request['volunteer_id']));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HealthCheck  $healthCheck
     * @return \Illuminate\Http\Response
     */
    public function show(HealthCheck $healthCheck)
    {
        if (auth()->user()->role == 'pet_shelter' || auth()->user()->role == 'volunteer') {
            $pet_shelter = User::find($healthCheck->shelter_id);
            $pet = Pet::find($healthCheck->pet_id);
            $medical_reports = MedicalReport::where('health_check_id', '=', $healthCheck->id)->first();
            return view('general.health-check-details', compact('healthCheck', 'pet_shelter', 'pet', 'medical_reports'));
        } else {
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HealthCheck  $healthCheck
     * @return \Illuminate\Http\Response
     */
    public function edit(HealthCheck $healthCheck)
    {
        if (auth()->user()->role == 'volunteer') {
            $pet_shelter = User::find($healthCheck->shelter_id);
            $pet = Pet::find($healthCheck->pet_id);

            return view('general.health-check-details', compact('healthCheck', 'pet_shelter', 'pet'));
        } else {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HealthCheck  $healthCheck
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HealthCheck $healthCheck)
    {
        $request->validate([
            'status' => 'required',
            'feedback' => ['required', 'string', 'max:500']
        ]);
        $healthCheck->update([
            'status' => Crypt::decrypt($request['status']),
            'feedback' => $request['feedback']
        ]);
        $pet_shelters = User::where('id', '=', $healthCheck->shelter_id)
                            ->first();
        $volunteer = User::where('id', '=', $healthCheck->volunteer_id)
                            ->first();
        $pet = Pet::where('id', '=', $healthCheck->pet_id)
                            ->first();
        $healthCheck->status == 'Accepted' ?
            $subject = 'Request Accepted' :
            $subject = 'Request Rejected';

        NotifyUser::sendNotifyVolunteer($pet_shelters, $volunteer,
                                        $pet, $healthCheck, $subject);
        return redirect()->route('health-checks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HealthCheck  $healthCheck
     * @return \Illuminate\Http\Response
     */
    public function destroy(HealthCheck $healthCheck)
    {
        //
    }
}
