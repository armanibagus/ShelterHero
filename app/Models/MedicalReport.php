<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalReport extends Model
{
    use HasFactory;
    protected $table = 'medical_reports';
    public $timestamps = true;

    protected $fillable = [
        'health_check_id',
        'allergies',
        'existing_condition',
        'vaccination',
        'diagnosis',
        'test_performed',
        'test_result',
        'action',
        'medication',
        'comments'
    ];
}
