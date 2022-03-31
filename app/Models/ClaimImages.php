<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimImages extends Model
{
    use HasFactory;

    protected $table = 'claim_images';

    protected $fillable = [
        'claim_id',
        'title',
        'path',
        'type'
    ];
}
