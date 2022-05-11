<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\Donate;
use App\Models\LostPetClaim;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified')->only('index', 'show', 'activityHistory');
        $this->middleware('user')->only('activityHistory');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role == 'user' || auth()->user()->role == 'volunteer') {
            $users = DB::table('users')
                ->where([['role', '=', 'pet_shelter'], ['email_verified_at', '!=', null]])
                ->get();
            return view('general.user-view', compact('users'));
        } else if (auth()->user()->role == 'pet_shelter') {
            $users = DB::table('users')
                ->where([['role', '=', 'volunteer'], ['email_verified_at', '!=', null]])
                ->get();
            return view('general.user-view', compact('users'));
        } else {
            return abort(404);
        }
    }

    public function activityHistory() {
        if (auth()->user()->role == 'user') {
            $adoptions = Adoption::join('pets', 'pets.id', '=', 'adoptions.pet_id')
                ->join('users', 'users.id', '=', 'pets.shelter_id')
                ->where('adoptions.user_id', auth()->user()->id)
                ->select(['pets.*', 'users.name', 'users.address',
                          'users.photo_path', 'users.photo_title', 'adoptions.status'])
                ->orderBy('created_at', 'DESC')
                ->latest()->get();
            $lost_pet_claims = LostPetClaim::join('pets', 'pets.id', '=', 'lost_pet_claims.pet_id')
                ->join('users', 'users.id', '=', 'pets.shelter_id')
                ->where('lost_pet_claims.user_id', '=', auth()->user()->id)
                ->select(['pets.*', 'users.name', 'users.address',
                          'users.photo_path', 'users.photo_title', 'lost_pet_claims.status'])
                ->orderBy('created_at', 'DESC')
                ->latest()->get();
            $donations = Donate::join('donations', 'donations.id', '=', 'donates.donation_id')
                ->join('donation_imgs', 'donation_imgs.donation_id', '=', 'donates.donation_id')
                ->join('users', 'users.id', '=', 'donations.shelter_id')
                ->select(['donates.*', 'donation_imgs.path', 'donations.title'])
                ->where([['donates.user_id', '=', auth()->user()->id],
                         ['donation_imgs.type', '=', 'donation']])
                ->orderBy('created_at', 'DESC')
                ->latest()->get();
            return view('user.activity-history',
                compact('adoptions', 'lost_pet_claims', 'donations'));
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
        if ((auth()->user()->role == 'user' || auth()->user()->role == 'volunteer')
            && $user->role == 'pet_shelter') {
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
            return view('general.user-details',
                compact('user', 'pets', 'acc_adopt_pets', 'acc_claim_pets'));
        } else if ((auth()->user()->role == 'pet_shelter' || auth()->user()->role == 'user')
            && $user->role == 'volunteer') {
            $pets = DB::table('pets')
                ->join('health_checks',
                    'health_checks.pet_id', '=', 'pets.id')
                ->join('medical_reports',
                    'medical_reports.health_check_id', '=', 'health_checks.id')
                ->where([['health_checks.status', '=', 'Accepted'],
                         ['health_checks.volunteer_id', '=', $user->id]])
                ->select(['health_checks.checkup_date', 'pets.*'])
                ->orderBy('health_checks.checkup_date', 'DESC')
                ->latest()->get();
            $health_check = DB::table('health_checks')
                ->where([['shelter_id', '=', auth()->user()->id],
                         ['volunteer_id', '=', $user->id]])
                ->latest()->get();
            $accepted_request = DB::table('health_checks')
                ->where([['volunteer_id', '=', $user->id],
                         ['status', '=', 'Accepted']])->count();
            return view('general.user-details',
                    compact('user', 'pets', 'health_check', 'accepted_request'));
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
            if ($user->photo_title != NULL && $user->photo_path != NULL) {
                // delete old photo
                $title = trim(str_replace("public", "", $user->photo_path));
                Storage::disk('public')->delete($title);
            }
            // get the photo
            $img = $request->file('profile_picture');
            // store the image
            $file_name = $img->getClientOriginalName();
            $img_path = $img->store('public/profile-picture');
            // store image details into database
            $user->update([
                'photo_title' => $file_name,
                'photo_path' => $img_path
            ]);
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
            if($user->role == 'user') {
                $request->validate([
                    'dateOfBirth' => ['required', 'date']
                ]);
                $user->dateOfBirth = $request->get('dateOfBirth');
            }
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
                $user->update([
                    'name' => $request->get('name'),
                    'phoneNumber' => $request->get('phoneNumber'),
                    'address' => $request->get('address')
                ]);
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
        return redirect()->back()->with('success', 'Profile successfully updated!');
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
