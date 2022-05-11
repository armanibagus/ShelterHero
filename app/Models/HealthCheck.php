<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthCheck extends Model
{
    use HasFactory;

    protected $table = 'health_checks';
    public $timestamps = true;

    protected $fillable = [
        'shelter_id',
        'volunteer_id',
        'pet_id',
        'checkup_date',
        'description',
        'status',
        'feedback'
    ];

    protected $dates = [
        'checkup_date'
    ];
}
