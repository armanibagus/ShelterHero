<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotifyUser extends Controller
{
    public function sendNotification($email, $data, $pet, $pet_shelter, $subject) {
        $message = [
            'title' => 'Hello '.$data->name.'!',
            'data' => $data,
            'pet' => $pet,
            'pet_shelter' => $pet_shelter,
            'subject' => $subject,
        ];
        Mail::to($email)->send(new SendMail($message));
        return 'Successfully send email!';
    }
}
