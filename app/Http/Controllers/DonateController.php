<?php

namespace App\Http\Controllers;

use App\Models\Donate;
use App\Models\Donation;
use App\Models\DonationImg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonateController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
        $this->middleware('user')->except('index', 'show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role == 'pet_shelter') {
            $donates = DB::table('donates')->latest()->get();
            return view('general.donates-view', compact('donates'));
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
        if (auth()->user()->role === 'user') {
            return view('user.donate-form');
        }
        else {
            return abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // validation
        $request->validate([
            'donation_id' => 'required',
            'user_id' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
            'payment_method' => ['required', 'string', 'max:50'],
            'donate_amount' => 'required',
            'receipt_img' => 'required|mimes:jpg,png,jpeg,gif,svg',
            'comment' => ['required', 'string', 'max:255']
        ]);
        // image checking
        if ($request->hasFile('receipt_img')) {
            $img = $request->file('receipt_img');
            // store the image
            $file_name = $img->getClientOriginalName();
            $img_path = $img->store('public/donation-img');
            // store image details into database
            $store[0]['title'] = $file_name;
            $store[0]['path'] = $img_path;
            $store[0]['type'] = 'donate';
            DonationImg::insert($store);
        }
        // store and update all the data
        $new_donate = Donate::create($request->all());
        DonationImg::where([['type', '=','donate'], ['donate_id', null]])
            ->update(['donate_id' => $new_donate->id]);

        return redirect()->route('donations.show', $new_donate->donation_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Donate  $donate
     * @return \Illuminate\Http\Response
     */
    public function show(Donate $donate)
    {
        if (auth()->user()->role == 'user' || auth()->user()->role == 'pet_shelter') {
            return view('general.donate-details', compact('donate'));
        } else {
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Donate  $donate
     * @return \Illuminate\Http\Response
     */
    public function edit(Donate $donate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Donate  $donate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Donate $donate)
    {
        // validation
        $request->validate([
            'status' => 'required',
            'feedback' => ['required', 'string', 'max:255']
        ]);
        // update data
        $donate->update($request->all());
        $donation_id = $donate->donation_id;
        $donate_amount = $donate->donate_amount;
        if($donate->status == 'Accepted') {
            $get_donation = DB::table('donations')->where('id', '=', $donation_id)->latest()->get();
            $amount_get = 0;
            foreach ($get_donation as $donation) {
                $amount_get = $donation->amount_get;
            }
            $amount_get += $donate_amount;
            Donation::where('id', '=', $donation_id)->update(['amount_get' => $amount_get]);
        }
        return redirect()->route('donates.show', $donate->id)
            ->with('success', 'Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Donate  $donate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Donate $donate)
    {
        //
    }
}
