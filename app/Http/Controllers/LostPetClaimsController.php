<?php

namespace App\Http\Controllers;

use App\Models\ClaimImages;
use App\Models\LostPetClaim;
use App\Models\Pet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LostPetClaimsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
        $this->middleware('user')->only('create');
        $this->middleware('petShelter')->only('edit');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // validate the authorities of the lost pet claim page
        if (auth()->user()->role == 'user') {
            $listPetClaims = array();

            // get pets data
            $allPets = DB::table('pets')->where('status', '=','Confirmed')->latest()->get();

            // filter pet confirmed and there is no lost pet claim proposed within 7 days
            foreach ($allPets as $pet) {
                $date = new \Carbon\Carbon($pet->pickUpDate);
                $expiredate = $date->addDays(7);
                if (\Carbon\Carbon::today() < $expiredate) {
                    $listPetClaims[] = $pet;
                }
            }

            // search for pets that have lost pet claims with status Pending or Rejected
            $listOfPets = $this->checkPets($listPetClaims);

            return view('user.lost-pet-claim', compact('listOfPets'));
        }
        else if (auth()->user()->role == 'pet_shelter') {
            $listPetClaims = array();
            $listOfPets = array();
            $shelter_id = auth()->user()->id;

            // get pets data and lost pet claims data
            $allPets = DB::table('pets')->where('shelter_id', $shelter_id)->latest()->get();
            $allClaims = DB::table('lost_pet_claims')->get();

            foreach ($allPets as $pet) {
                $date = new \Carbon\Carbon($pet->pickUpDate);
                $expiredate = $date->addDays(7);
                if ($pet->status === 'Confirmed' && \Carbon\Carbon::today() < $expiredate) {
                    $listOfPets[] = $pet;
                }
            }

            foreach ($listOfPets as $pet) {
                $have_claim = false; $pending = false;
                foreach ($allClaims as $claim) {
                    if($pet->id == $claim->pet_id) {
                        $have_claim = true;
                        if ($claim->status == 'Pending') {
                            $pending = true;
                        } else if ($claim->status == 'Accepted') {
                            $pending = false;
                            break;
                        }
                    }
                }
                if ($have_claim && $pending) {
                    $listPetClaims[] = $pet;
                }
            }

            return view('pet_shelter.lost-pet-claim', compact('listPetClaims'));
        }
        else {
            return abort(404);
        }
    }

    // function with parameter and return type declaration
    // this function used to check pets by several condition
    protected function checkPets($listOfPets): array
    {
        $newData = array();
        $allClaims = DB::table('lost_pet_claims')->get();
        if (auth()->user()->role == 'user') {
            $have_claim = -1; $acc = -1;
            foreach ($listOfPets as $pet) {
                foreach ($allClaims as $claim) {
                    if ($pet->id == $claim->pet_id) {
                        $have_claim = 1;
                        if ($claim->status === 'Pending' || $claim->status === 'Rejected') {
                            $acc = -1;
                        }
                        else {
                            $acc = 1;
                            break;
                        }
                    }
                }
                if ($have_claim < 0) {
                    $newData[] = $pet;
                }
                else {
                    if ($acc < 0) {
                        $newData[] = $pet;
                    }
                }
            }
        }
        return $newData;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // validate the authorities of the lost pet claim form page
        if (auth()->user()->role == 'user') {
            return view('user.pet-claim-form');
        }
        else {
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
        // validate the data
        $request->validate([
            'user_id' => 'required',
            'shelter_id' => 'required',
            'pet_id' => 'required',
            'user_idNumber' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'country' => ['required', 'string'],
            'postal' => ['required', 'string'],
            'proof_of_img' => 'required',
            'proof_of_img.*' => 'mimes:jpg,png,jpeg,gif,svg',
            'birth_certificate_img.*' => 'mimes:jpg,png,jpeg,gif,svg',
            'appropriate_img.*' => 'mimes:jpg,png,jpeg,gif,svg',
            'other_information' => ['required', 'string', 'max:300']
        ]);
        if ($request->hasfile('proof_of_img')) {
            foreach ($request->file('proof_of_img') as $key => $file) {
                // get and store the images
                $path = $file->store('public/pet-claim-img');
                $fileName = $file->getClientOriginalName();
                // assign the name, path, and type to variable used to store value into the database
                $insert[$key]['title'] = $fileName;
                $insert[$key]['path'] = $path;
                $insert[$key]['type'] = 'proof_of_img';
            }
            ClaimImages::insert($insert);
        }
        if ($request->hasfile('birth_certificate_img')) {
            foreach ($request->file('birth_certificate_img') as $key => $file) {
                // get and store the images
                $path = $file->store('public/pet-claim-img');
                $fileName = $file->getClientOriginalName();
                // assign the name, path, and type to variable used to store value into the database
                $insert[$key]['title'] = $fileName;
                $insert[$key]['path'] = $path;
                $insert[$key]['type'] = 'birth_certificate_img';
            }
            ClaimImages::insert($insert);
        }
        if ($request->hasfile('appropriate_img')) {
            foreach ($request->file('appropriate_img') as $key => $file) {
                // get and store the images
                $path = $file->store('public/pet-claim-img');
                $fileName = $file->getClientOriginalName();
                // assign the name, path, and type to variable used to store value into the database
                $insert[$key]['title'] = $fileName;
                $insert[$key]['path'] = $path;
                $insert[$key]['type'] = 'appropriate_img';
            }
            ClaimImages::insert($insert);
        }

        $claim = LostPetClaim::create($request->all());

        // get claim ID an update the claim images database
        $claimID = $claim->id;
        ClaimImages::where('claim_id', null)->update(['claim_id' => $claimID]);

        $id = $claim->pet_id;

        return redirect()->route('pets.show', $id)
            ->with('success', 'Claim successfully send!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LostPetClaim  $lostPetClaim
     * @return \Illuminate\Http\Response
     */
    public function show(LostPetClaim $lostPetClaim)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LostPetClaim  $lostPetClaim
     * @return \Illuminate\Http\Response
     */
    public function edit(LostPetClaim $lostPetClaim)
    {
        if (auth()->user()->role == 'pet_shelter') {
            $data = $lostPetClaim;
            return view('pet_shelter.confirmation-page', compact('data'));
        }
        else {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LostPetClaim  $lostPetClaim
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LostPetClaim $lostPetClaim)
    {
        // validate the data
        $request->validate([
            'status' => 'required',
            'feedback' => ['required', 'string', 'max:300'],
        ]);
        // update claim object
        $lostPetClaim->update($request->all());

        $pet_id = $lostPetClaim->pet_id;
        $shelter_id = $lostPetClaim->shelter_id;
        $pet = new Pet();
        $shelter = new User();

        $table1 = DB::table('pets')->where('id', '=', $pet_id)->get();
        $table2 = DB::table('users')->where('id', '=', $shelter_id)->get();
        foreach ($table1 as $pets) {
            $pet = $pets;
        }
        foreach ($table2 as $users) {
            $shelter = $users;
        }

        $subject = '';
        if ($request['status'] === 'Accepted') {
            $subject = 'Lost Pet Claim Accepted';
        } else if ($request['status'] === 'Rejected') {
            $subject = 'Lost Pet Claim Rejected';
        }
        NotifyUser::sendNotification($lostPetClaim->email, $lostPetClaim, $pet, $shelter, $subject);

        return redirect()->route('pets.show', $pet_id)
            ->with('success', 'Claim successfully updated!');
    }

    public function rejectClaim() {
        $listClaims = DB::table('lost_pet_claims')->get();
        foreach ($listClaims as $claim) {
            $date = new \Carbon\Carbon($claim->created_at);
            $expiredate = $date->addDays(3);
            if (Carbon::now() > $expiredate && $claim->status === 'Pending') {
                DB::table('lost_pet_claims')->where('id', '=', $claim->id)->update(['status' => 'Rejected']);
                $claims = DB::table('lost_pet_claims')->where('id', '=', $claim->id)->get();
                $new_claim = new LostPetClaim();
                foreach ($claims as $c) {
                    $new_claim = $c;
                }
                $pet_id = $new_claim->pet_id;
                $shelter_id = $new_claim->shelter_id;
                $pet = new Pet();
                $shelter = new User();

                $table1 = DB::table('pets')->where('id', '=', $pet_id)->get();
                $table2 = DB::table('users')->where('id', '=', $shelter_id)->get();
                foreach ($table1 as $pets) {
                    $pet = $pets;
                }
                foreach ($table2 as $users) {
                    $shelter = $users;
                }
//                $shelter(['name' => 'system, because the request is expired']);
                $subject = 'Lost Pet Claim Rejected';
                NotifyUser::sendNotification($new_claim->email, $new_claim, $pet, $shelter, $subject);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LostPetClaim  $lostPetClaims
     * @return \Illuminate\Http\Response
     */
    public function destroy(LostPetClaim $lostPetClaims)
    {
        //
    }
}
