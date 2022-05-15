<?php

namespace App\Http\Controllers;

use App\Models\MedicalReport;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MedicalReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('volunteer')->only('index', 'create', 'edit');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role == 'volunteer') {
            $medical_reports = Pet::join('health_checks', 'health_checks.pet_id', '=', 'pets.id')
                ->join('medical_reports', 'medical_reports.health_check_id', '=', 'health_checks.id')
                ->join('users', 'users.id', '=', 'health_checks.shelter_id')
                ->select(['health_checks.id', 'health_checks.pet_id', 'pets.nickname', 'pets.petType',
                            'pets.size', 'pets.sex', 'users.name', 'medical_reports.created_at'])
                ->where('health_checks.volunteer_id', '=', auth()->user()->id)
                ->orderBy('medical_reports.created_at', 'DESC')
                ->latest()->get();
            return view('volunteer.view-pet-medical-history', compact('medical_reports'));
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
        if (auth()->user()->role == 'volunteer') {
            return view('volunteer.medical-report-form');
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
            'health_check_id' => 'required',
            'allergies' => ['required', 'string'],
            'existing_condition' => ['required', 'string'],
            'diagnosis' => ['required', 'string'],
            'test_performed' => ['required', 'string'],
            'test_result' => ['required', 'string'],
            'action' => ['required', 'string'],
            'medication' => ['required', 'string'],
            'comments' => ['required', 'string', 'max:500'],
        ]);

        MedicalReport::create([
            'health_check_id' => Crypt::decrypt($request['health_check_id']),
            'allergies' => $request['allergies'],
            'existing_condition' => $request['existing_condition'],
            'vaccination' => $request['vaccination'],
            'diagnosis' => $request['diagnosis'],
            'test_performed' => $request['test_performed'],
            'test_result' => $request['test_result'],
            'action' => $request['action'],
            'medication' => $request['medication'],
            'comments' => $request['comments']
        ]);

        return redirect()->route('health-checks.show',
            Crypt::decrypt($request['health_check_id']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MedicalReport  $medicalReport
     * @return \Illuminate\Http\Response
     */
    public function show(MedicalReport $medicalReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MedicalReport  $medicalReport
     * @return \Illuminate\Http\Response
     */
    public function edit(MedicalReport $medicalReport)
    {
        if (auth()->user()->role == 'volunteer') {
            return view('volunteer.medical-report-form', compact('medicalReport'));
        } else {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MedicalReport  $medicalReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MedicalReport $medicalReport)
    {
        $request->validate([
            'allergies' => ['required', 'string'],
            'existing_condition' => ['required', 'string'],
            'diagnosis' => ['required', 'string'],
            'test_performed' => ['required', 'string'],
            'test_result' => ['required', 'string'],
            'action' => ['required', 'string'],
            'medication' => ['required', 'string'],
            'comments' => ['required', 'string', 'max:500'],
        ]);

        $medicalReport->update($request->all());
        return redirect()->route('health-checks.show',
                                    $medicalReport->health_check_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MedicalReport  $medicalReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalReport $medicalReport)
    {
        //
    }
}
