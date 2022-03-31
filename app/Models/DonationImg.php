<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationImg extends Model
{
    use HasFactory;

    protected $table = 'donation_imgs';

    protected $fillable = [
        'donation_id',
        'donate_id',
        'title',
        'path',
        'type'
    ];
}
