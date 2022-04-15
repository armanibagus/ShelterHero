<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified')->only('allPetShelter', 'show');
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (Auth::user()->id == $user->id) {
            return view('general.user-profile', compact('user'));
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($request->hasFile('profile_picture')) {
            $request->validate([
                'profile_picture' => 'required|mimes:jpg,png,jpeg,gif,svg',
            ]);

            $img = $request->file('profile_picture');
            // store the image
            $file_name = $img->getClientOriginalName();
            $img_path = $img->store('public/profile-picture');

            // store image details into database
            $user->update([
                'photo_title' => $file_name,
                'photo_path' => $img_path
            ]);
            echo $file_name;
            echo $img_path;
        } else {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'phoneNumber' => ['required', 'max:15'],
                'address' => ['required', 'string']
            ]);
            $user->update([
                'name' => $request->get('name'),
                'phoneNumber' => $request->get('phoneNumber'),
                'address' => $request->get('address')
            ]);
            if ($request->get('identityNumber') != $user->identityNumber) {
                $request->validate([
                    'identityNumber' => ['required', 'string', 'unique:users']
                ]);
                $user->identityNumber = $request->get('identityNumber');
            }
            if ($request->get('username') != $user->username) {
                $request->validate([
                    'username' => ['required', 'string', 'min:8', 'max:16', 'unique:users']
                ]);
                $user->username = $request->get('username');
            }
            if ($request->get('email') != $user->email) {
                $request->validate([
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
                ]);
                $user->email = $request->get('email');
                $user->email_verified_at = NULL;
                $user->sendEmailVerificationNotification();
            }
            if ($request->get('old_password') != '' ||
                $request->get('new_password') != '' ||
                $request->get('password_confirmation') != '') {
                $request->validate([
                    'old_password' => ['required', 'password'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                    'password_confirmation' => 'required'
                ]);
                $user->password = Hash::make($request->get('password'));
            }
            $user->save();
        }
        return redirect()->back();
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
