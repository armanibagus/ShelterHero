<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $table = 'donations';
    public $timestamps = true;

    protected $fillable = [
        'shelter_id',
        'user_idNumber',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal',
        'bank_name',
        'accountName',
        'CCNumber',
        'title',
        'amount_need',
        'amount_get',
        'expiry_date',
        'purpose',
        'donation_recipient',
        'description'
    ];

    protected $dates = [
        'expiry_date'
    ];
}
