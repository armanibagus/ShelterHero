<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donate extends Model
{
    use HasFactory;

    protected $table = 'donates';

    protected $fillable = [
        'donation_id',
        'user_id',
        'name',
        'email',
        'phone',
        'payment_method',
        'donate_amount',
        'comment',
        'status',
        'feedback'
    ];
}
