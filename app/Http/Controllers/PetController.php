<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
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
        if(auth()->user()->role == 'user'
            || auth()->user()->role == 'pet_shelter'
            || auth()->user()->role == 'volunteer') {
            // get all pets data from database
            $pets = DB::table('users')
                ->join('pets', 'pets.shelter_id', '=', 'users.id')
                ->select(['pets.*', 'users.name', 'users.address'])
                ->latest()->get();
            // get all lost pet claims data from database
            $petClaims = DB::table('lost_pet_claims')->get();
            // get all adoptions data from database
            $petAdopt = DB::table('adoptions')->get();
            // filter pets by lost pet claims
            $filter_pets1 = $this->validatePets($pets, $petClaims);
            // filter pets by adoptions
            $filter_pets2 = $this->validatePets($filter_pets1, $petAdopt);
            // filter pets status must be 'Confirmed'
            $allPets = array();
            foreach ($filter_pets2 as $pet) {
                if ($pet->status == 'Confirmed') {
                    $allPets[] = $pet;
                }
            }
            // display
            return view('general.pets-view', compact('allPets'));
        }
        else {
            return abort(404);
        }
    }

    public function myPets()
    {
        if (auth()->user()->role == 'pet_shelter') {
            $allPets = DB::table('users')
                ->join('pets', 'pets.shelter_id', '=', 'users.id')
                ->select(['pets.*', 'users.name', 'users.address'])
                ->where([
                    ['shelter_id', '=', auth()->user()->id],
                    ['status', '=', 'Confirmed']
                ])
                ->latest()->get();
            $table_adopt = DB::table('adoptions')->get();
            $table_claim = DB::table('lost_pet_claims')->get();

            $adopted_pets = $this->getAcceptedPet($allPets, $table_adopt);
            $claimed_pets = $this->getAcceptedPet($allPets, $table_claim);

            return view('general.pets-view',
                compact('allPets', 'adopted_pets', 'claimed_pets'));
        } else {
            return abort(404);
        }
    }

    public function lostPets()
    {
        if (auth()->user()->role == 'user') {
            $lost_pets = array();
            $pets = DB::table('users')
                ->join('pets', 'pets.shelter_id', '=', 'users.id')
                ->select(['pets.*', 'users.name', 'users.address'])
                ->latest()->get();
            $petClaims = DB::table('lost_pet_claims')->get();
            $valid_pets = $this->validatePets($pets, $petClaims);
            foreach ($valid_pets as $pet) {
                $date = new \Carbon\Carbon($pet->pickUpDate);
                $expiredate = $date->addDays(7);
                if ($pet->status === 'Confirmed' && \Carbon\Carbon::today() < $expiredate) {
                    $lost_pets[] = $pet;
                }
            }
            return view('user.view-lost-pet', compact('lost_pets'));
        } else {
            return abort(404);
        }
    }

    public function viewPetRegis() {
        $pets = DB::table('users')
            ->join('pets', 'pets.user_id', '=', 'users.id')
            ->select(['pets.*', 'users.name', 'users.address'])
            ->latest()->get();
        return view('pet_shelter.pet-registration', compact('pets'));
    }

    // method used to get all pets by specific user
    public function getAllPetsBy(User $user) : array
    {
        // get all the data from database
        $allPets = DB::table('users')
            ->join('pets', 'pets.shelter_id', '=', 'users.id')
            ->select(['pets.*', 'users.name', 'users.address'])
            ->where([['shelter_id', '=', $user->id],
                ['status', '=', 'Confirmed']])
            ->latest()->get();
        $petClaims = DB::table('lost_pet_claims')->get();
        $petAdopt = DB::table('adoptions')->get();

        // filter pets by lost pet claims
        $filter_pets2 = PetController::validatePets($allPets, $petClaims);
        // filter pets by adoptions
        $pets = PetController::validatePets($filter_pets2, $petAdopt);

        return $pets;
    }

    public function getAcceptedPet($pets, $data) : array {
        $filtered_pets = array();
        foreach ($pets as $pet) {
            foreach ($data as $param) {
                if($pet->id == $param->pet_id) {
                    if ($param->status === 'Accepted') {
                        $filtered_pets[] = $pet;
                        break;
                    }
                }
            }
        } return $filtered_pets;
    }

    // function to validate the pets data
    public function validatePets($data1, $data2) :array {
        $pets = array();
        foreach ($data1 as $pet) {
            $have_it = -1; $accepted = -1;
            foreach ($data2 as $obj) {
                if ($pet->id == $obj->pet_id) {
                    $have_it = 1;
                    if ($obj->status == 'Accepted') {
                        $accepted = 1;
                        break;
                    }
                }
            }
            if ($have_it < 0) {
                $pets[] = $pet;
            } else {
                if ($accepted < 0) {
                    $pets[] = $pet;
                }
            }
        }
        return $pets;
    }

    public function petIsAccepted($pet, $data): bool {
        foreach ($data as $param) {
            if($pet->id == $param->pet_id) {
                if ($param->status === 'Accepted') {
                    return true;
                }
            }
        } return false;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // validate the authorities of the register pet form
        if (auth()->user()->role == 'user') {
            $pets = Pet::paginate();
            return view('user.register-pet', compact('pets'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
        } else {
            return redirect()->route('home');
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
        // validate the input
        $request->validate([
            'nickname' => ['required', 'string', 'max:255'],
            'petType' => ['required', 'string'],
            'sex' => ['required', 'string'],
            'age' => ['required'],
            'size' => ['required', 'string'],
            'weight' => ['required'],
            'condition' => ['required', 'string', 'max:500'],
            'images' => 'required',
            'images.*' => 'mimes:jpg,png,jpeg,gif,svg'
        ]);

        // get the images input
        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $key => $file) {
                // get
                $path = $file->store('public/images');
                $name = $file->getClientOriginalName();
                // store
                $insert[$key]['title'] = $name;
                $insert[$key]['path'] = $path;
            }
        }

        // create pet object
        $data = Pet::create($request->all());

        // insert image to database
        Image::insert($insert);

        // update pet_id (foreign key) in images database
        $idPet = $data->id;
        Image::where('pet_id', null)->update(['pet_id' => $idPet]);

        // redirect to registration form
        return redirect()->route('pets.create')
            ->with('success', 'Pet successfully registered!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Pet $pet)
    {
        if (auth()->user()) {
            return view('general.pet-details', compact('pet'));
        } else {
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function edit(Pet $pet)
    {
        // validate the authorities of the edit form
        if (auth()->user()->role == 'pet_shelter') {
            return view('pet_shelter.edit-pet', compact('pet'));
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pet $pet)
    {
        // filter the pet with the status
        $pet->status == 'Confirmed' ? $edit = true : $edit = false;
        if ($edit) {
            $request->validate([
                'nickname' => ['required', 'string', 'max:255'],
                'petType' => ['required', 'string'],
                'sex' => ['required', 'string'],
                'age' => ['required'],
                'size' => ['required', 'string'],
                'weight' => ['required'],
                'condition' => ['required', 'string', 'max:500']
            ]);
            $pet->update([
                'nickname' => $request['nickname'],
                'petType' => Crypt::decrypt($request['petType']),
                'sex' => Crypt::decrypt($request['sex']),
                'age' => $request['age'],
                'size' => Crypt::decrypt($request['size']),
                'weight' => $request['weight'],
                'condition' => $request['condition']
            ]);
            if ($request->hasFile('images')) {
                $request->validate([
                    'images' => 'required',
                    'images.*' => 'mimes:jpg,png,jpeg,gif,svg'
                ]);
                $pet_images = Image::where('pet_id', '=', $pet->id)->get();
                foreach ($pet_images as $image) {
                    $image->delete();
                    $title = trim(str_replace("public","", $image->path));
                    Storage::disk('public')->delete($title);
                }
                foreach ($request->file('images') as $key => $file) {
                    // get
                    $path = $file->store('public/images');
                    $name = $file->getClientOriginalName();
                    // store
                    $insert[$key]['title'] = $name;
                    $insert[$key]['path'] = $path;
                }
                // insert image to database
                Image::insert($insert);

                // update pet_id (foreign key) in images database
                Image::where('pet_id', null)->update(['pet_id' => $pet->id]);
            }
            return redirect()->route('pets.show', $pet->id);
        } else {
            if ($pet->pickUpDate == NULL) {
                $request->validate([
                    'pickUpDate' => 'required'
                ]);
                $pet->update([
                    'shelter_id' => auth()->user()->id,
                    'status' => 'Picked Up',
                    'pickUpDate' => $request['pickUpDate']
                ]);
            } else {
                $pet->update([
                    'status' => 'Confirmed',
                ]);
            }
            return redirect()->route('pets.viewPetRegis');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pet $pet)
    {
        //
    }
}
