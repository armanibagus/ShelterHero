<?php

namespace App\Http\Controllers;

use App\Models\HealthCheck;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HealthCheckController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('petShelter')->only('create', 'show');
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
            $health_checks = DB::table('users')
                ->join('health_checks', 'health_checks.shelter_id', '=', 'users.id')
                ->select(['health_checks.*', 'users.name', 'users.address', 'users.photo_path', 'users.photo_title'])
                ->where([['status', '=', 'Pending'],
                         ['volunteer_id', '=', auth()->user()->id]])
                ->latest()->get();
            return view('volunteer.view-health-checks', compact('health_checks'));
        } else {
            return abort(404);
        }
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

            return view('pet_shelter.req-volunteer-form', compact('total_volunteer'));
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
            'checkup_date' => 'required',
            'description' => ['required', 'string', 'max:500']
        ]);

        HealthCheck::create([
            'shelter_id' => auth()->user()->id,
            'volunteer_id' => $request['volunteer_id'],
            'checkup_date' => $request['checkup_date'],
            'description' => $request['description']
        ]);

        return redirect()->route('users.show', $request['volunteer_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HealthCheck  $healthCheck
     * @return \Illuminate\Http\Response
     */
    public function show(HealthCheck $healthCheck)
    {
        if (auth()->user()->role == 'pet_shelter') {
            $pet_shelter = new User();
            $users = DB::table('users')
                ->where('id', '=', $healthCheck->shelter_id)->get();
            foreach ($users as $user) {
                $pet_shelter = $user;
            }

            return view('general.health-check-details', compact('healthCheck', 'pet_shelter'));
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
            $pet_shelter = new User();
            $users = DB::table('users')
                ->where('id', '=', $healthCheck->shelter_id)->get();
            foreach ($users as $user) {
                $pet_shelter = $user;
            }

            return view('general.health-check-details', compact('healthCheck', 'pet_shelter'));
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

        $healthCheck->update($request->all());
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
