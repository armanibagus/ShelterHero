<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationImg;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
        $this->middleware('petShelter')->except('index', 'show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role === 'user') {
            $allDonations = DB::table('donations')
                ->where('expiry_date', '>', Carbon::now())->latest()->get();
            return view('general.donation-view', compact('allDonations'));
        }
        else if (auth()->user()->role === 'pet_shelter') {
            $allDonations = DB::table('donations')
                ->where('shelter_id', '=', auth()->user()->id)->latest()->get();
            return view('general.donation-view', compact('allDonations'));
        }
        else {
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
        if (auth()->user()->role === 'pet_shelter') {
            return view('pet_shelter.donation-form');
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
            'shelter_id' => 'required',
            'user_idNumber' => 'required',
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
            'address' => ['required', 'string', 'max:150'],
            'city' => ['required', 'string', 'max:50'],
            'state' => ['required', 'string', 'max:50'],
            'country' => ['required', 'string', 'max:50'],
            'postal' => ['required', 'string', 'max:50'],
            'bank_name' => ['required', 'string', 'max:50'],
            'accountName' => ['required', 'string', 'max:255'],
            'CCNumber' => ['required', 'string', 'max:50'],
            'title' => ['required', 'string', 'max:50'],
            'amount_need' => 'required',
            'expiry_date' => 'required',
            'purpose' => ['required', 'string', 'max:255'],
            'donation_recipient' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500'],
            'donation_img' => ['required', 'mimes:jpg,png,jpeg,gif,svg']
        ]);

        // check the image file
        if ($request->hasFile('donation_img')) {
            // get the image
            $image = $request->file('donation_img');

            // get image path and name
            $path = $image->store('public/donation-img');
            $fileName = $image->getClientOriginalName();

            // store the image
            $insert[0]['title'] = $fileName;
            $insert[0]['path'] = $path;
            $insert[0]['type'] = 'donation';
            DonationImg::insert($insert);
        }

        // store the donation object
        $donation = Donation::create($request->all());

        // assign donation id to donation image object
        DonationImg::where([['type', '=','donation'], ['donation_id', null]])
                            ->update(['donation_id' => $donation->id]);

        return redirect()->route('donations.create')
            ->with('success', 'Request successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function show(Donation $donation)
    {
        if (auth()->user()->role == 'user' || auth()->user()->role == 'pet_shelter' ) {
            return view('general.donation-details', compact('donation'));
        }
        else {
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function edit(Donation $donation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Donation $donation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Donation $donation)
    {
        //
    }
}
