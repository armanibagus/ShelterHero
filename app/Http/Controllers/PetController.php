<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // differentiate the index view by users role and command
        if (auth()->user()->role == 'pet_shelter') {
            $pets = DB::table('users')
                ->join('pets', 'pets.user_id', '=', 'users.id')
                ->select(['pets.*', 'users.name', 'users.address'])
                ->paginate(5);

            return view('pet_shelter.pet-registration', compact('pets'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
        }
        else if(auth()->user()->role == 'user') {
            $pets = DB::table('users')
                ->join('pets', 'pets.shelter_id', '=', 'users.id')
                ->select(['pets.*', 'users.name', 'users.address'])
                ->latest()->paginate(5);

            return view('user.view-lost-pet', compact('pets'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
        } else {
            return redirect()->route('home');
        }
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
     * @return \Illuminate\Http\Response
     */
    public function show(Pet $pet)
    {
        //
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
        // validate the input
        if ($request['status'] === 'Confirmed') {
            $request->validate([
                'status' => 'required'
            ]);
        } else if ($request['status'] === 'Picked up') {
            $request->validate([
                'shelter_id' => 'required',
                'status' => 'required',
                'pickUpDate' => 'required'
            ]);
        } else {
            $request->validate([
                'nickname' => 'required',
                'petType' => 'required',
                'sex' => 'required',
                'age' => 'required',
                'size' => 'required',
                'weight' => 'required',
                'condition' => 'required'
            ]);
        }

        // update pet information
        $pet->update($request->all());

        // redirect to pet registration page
        return redirect()->route('pets.index')
            ->with('success', 'Pet successfully updated!');
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
