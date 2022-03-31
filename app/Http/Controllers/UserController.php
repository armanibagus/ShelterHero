<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function allPetShelter() {
        if (auth()->user()->role == 'user' || auth()->user()->role == 'volunteer') {
            $pet_shelters = DB::table('users')
                ->where([['role', '=', 'pet_shelter'], ['email_verified_at', '!=', null]])
                ->get();
            return view('general.pet-shelter-view', compact('pet_shelters'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if (auth()->user()->role == 'user' || auth()->user()->role == 'volunteer') {
            // get all pets in the pet shelter and related data from database
            $pets = DB::table('users')
                ->join('pets', 'pets.shelter_id', '=', 'users.id')
                ->select(['pets.*', 'users.name', 'users.address'])
                ->where([['shelter_id', '=', $user->id],
                    ['status', '=', 'Confirmed']])
                ->latest()->get();
            $petAdopt = DB::table('adoptions')->get();
            $petClaims = DB::table('lost_pet_claims')->get();
            //  search pets
            $acc_adopt_pets = PetController::getAcceptedPet($pets, $petAdopt);
            $acc_claim_pets = PetController::getAcceptedPet($pets, $petClaims);
            // display
            return view('general.pet-shelter-details',
                compact('user', 'pets', 'acc_adopt_pets', 'acc_claim_pets'));
        } else {
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
