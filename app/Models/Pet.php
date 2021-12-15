<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $table = 'pets';
    public $timestamps = true;

    protected $casts = [
        'weight' => 'float'
    ];

    protected $fillable = [
        'user_id',
        'shelter_id',
        'nickname',
        'petType',
        'sex',
        'age',
        'size',
        'weight',
        'condition',
        'status',
        'pickUpDate'
    ];

    protected $dates = [
        'pickUpDate'
    ];
}
