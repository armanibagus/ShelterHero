<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\Pet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdoptionController extends Controller
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
        // validate the authorities of the pet adoption page
        if (auth()->user()->role == 'user') {
            // get all the data needed from database
            $allPets = DB::table('users')
                ->join('pets', 'pets.shelter_id', '=', 'users.id')
                ->select(['pets.*', 'users.name', 'users.address'])
                ->latest()->get();
            $petClaims = DB::table('lost_pet_claims')->get();
            $petAdopt = DB::table('adoptions')->get();

            // filter pet confirmed and there is no lost pet claim proposed within 7 days
            $filter_pets1 = array();
            foreach ($allPets as $pet) {
                $date = new \Carbon\Carbon($pet->pickUpDate);
                $expiredate = $date->addDays(7);
                if ($pet->status === 'Confirmed' && \Carbon\Carbon::today() > $expiredate) {
                    $filter_pets1[] = $pet;
                }
            }
            // filter pets by lost pet claims
            $filter_pets2 = PetController::validatePets($filter_pets1, $petClaims);
            // filter pets by adoptions
            $pets = PetController::validatePets($filter_pets2, $petAdopt);

            // display
            return view('user.pet-adoption', compact('pets'));
        } else if (auth()->user()->role == 'pet_shelter') {
            // get data from database
            $allPets = DB::table('pets')
                ->where([['shelter_id', '=', auth()->user()->id],
                        ['status', '=', 'Confirmed']])
                ->latest()->get();
            $allAdoptions = DB::table('adoptions')->get();
            $petClaims = DB::table('lost_pet_claims')->get();

            // filter pets by pending adoptions
            $pendingAdoptPet = array();
            foreach ($allPets as $pet) {
                $have_adopt = false; $pending = false;
                $date = new \Carbon\Carbon($pet->pickUpDate);
                $expiredate = $date->addDays(7);
                if (\Carbon\Carbon::today() > $expiredate) {
                    foreach ($allAdoptions as $adopt) {
                        if($pet->id == $adopt->pet_id) {
                            $have_adopt = true;
                            if ($adopt->status === 'Pending') {
                                $pending = true;
                            } else if ($adopt->status == 'Accepted'){
                                $pending = false;
                                break;
                            }
                        }
                    }
                    if ($pending && $have_adopt) {
                        $pendingAdoptPet[] = $pet;
                    }
                }
            }
            // filter pets by lost pet claims
            $pets = PetController::validatePets($pendingAdoptPet, $petClaims);

            // display
            return view('pet_shelter.adoption-request', compact('pets'));
        }else {
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
        // validate the authorities of the request pet adoption form page
        if (auth()->user()->role == 'user') {
            return view('user.adoption-form');
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
        // validate user input
        $request->validate([
            'user_id' => 'required',
            'shelter_id' => 'required',
            'pet_id' => 'required',
            'user_idNumber' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'adopter_age' => 'required',
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'country' => ['required', 'string'],
            'postal' => ['required', 'string'],
            'occupation' => ['required', 'string', 'max:255'],
            'salary' => 'required',
            'no_of_pet_owned' => 'required',
            'pets_description' => ['required', 'string', 'max:300'],
            'home_question' => 'required',
            'rehomed_question' => 'required',
            'rehomed_description' => ['max:300'],
            'family_member' => ['required', 'string'],
            'other_information' => ['required', 'string', 'max:300']
        ]);

        // create adoption object and store it to database
        $data = Adoption::create($request->all());

        // get pet id
        $pet_id = $data->pet_id;

        // redirect to pet details page
        return redirect()->route('pets.show', $pet_id)
            ->with('success', 'Request successfully send!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adoption  $adoption
     * @return \Illuminate\Http\Response
     */
    public function show(Adoption $adoption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Adoption  $adoption
     * @return \Illuminate\Http\Response
     */
    public function edit(Adoption $adoption)
    {
        // validate the authorities of this action
        if (auth()->user()->role == 'pet_shelter') {
            $data = $adoption;
            return view('pet_shelter.confirmation-page', compact('data'));
        } else {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Adoption  $adoption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Adoption $adoption)
    {
        // validate user input
        $request->validate([
            'status' => 'required',
            'feedback' => ['required', 'string', 'max:300'],
        ]);
        // update adoption information
        $adoption->update($request->all());

        // get several data from database
        $pets_data = DB::table('pets')->get();
        $users_data = DB::table('users')->get();

        // get objects by its id
        $pet_data = new Pet();
        $shelter_data = new User();
        foreach ($pets_data as $pet) {
            if ($pet->id == $adoption->pet_id) {
                $pet_data = $pet;
            }
        }
        foreach ($users_data as $user) {
            if ($user->id == $adoption->shelter_id) {
                $shelter_data = $user;
            }
        }

        // get the subject by adoption status
        $request['status'] === 'Accepted' ?
            $subject = 'Adoption Accepted' :
            $subject = 'Adoption Rejected';

        // send email notification to user
        NotifyUser::sendNotification($adoption->email, $adoption, $pet_data, $shelter_data, $subject);

        // get pet id
        $pet_id = $adoption->pet_id;

        // redirect to previous page
        return redirect()->route('pets.show', $pet_id)
            ->with('success', 'Request successfully updated!');
    }

    public function autoRejectAdoption() {
        $allAdopt = DB::table('adoptions')
            ->where('status', '=', 'Pending')
            ->get();
        foreach ($allAdopt as $adopt) {
            $date = new \Carbon\Carbon($adopt->pickUpDate);
            $expiredate = $date->addDays(3);
            if (Carbon::now() > $expiredate) {
                DB::table('adoptions')
                    ->where('id', '=', $adopt->id)
                    ->update(['status' => 'Rejected']);

                // get several data from database
                $listOfAdopt = DB::table('adoptions')->get();
                $pets_data = DB::table('pets')->get();
                $users_data = DB::table('users')->get();

                // get objects by its id
                $updated_adopt = new Adoption();
                $pet_data = new Pet();
                $shelter_data = new User();
                foreach ($listOfAdopt as $item) {
                    if ($item->id == $adopt->id)
                        $updated_adopt = $item;
                }
                foreach ($pets_data as $pet) {
                    if ($pet->id == $updated_adopt->pet_id) {
                        $pet_data = $pet;
                    }
                }
                foreach ($users_data as $user) {
                    if ($user->id == $updated_adopt->shelter_id) {
                        $shelter_data = $user;
                    }
                }

                // set the subject
                $subject = 'Adoption Rejected';

                // send email notification to user
                NotifyUser::sendNotification($updated_adopt->email, $updated_adopt, $pet_data, $shelter_data, $subject);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adoption  $adoption
     * @return \Illuminate\Http\Response
     */
    public function destroy(Adoption $adoption)
    {
        //
    }
}
