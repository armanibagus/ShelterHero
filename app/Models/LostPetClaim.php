<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LostPetClaim extends Model
{
    use HasFactory;

    protected $table = 'lost_pet_claims';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'shelter_id',
        'pet_id',
        'user_idNumber',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal',
        'other_information',
        'status',
        'delivery_date',
        'feedback'
    ];

    protected $dates = [
        'delivery_date'
    ];
}
