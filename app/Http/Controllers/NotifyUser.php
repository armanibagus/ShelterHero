<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Mail\SendVolunteerMail;
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

    public function sendNotifyVolunteer($pet_shelter, $volunteer, $pet, $request, $subject) {
        $message = [
            'title' => 'Hello '.$pet_shelter->name.'!',
            'request' => $request,
            'volunteer' => $volunteer,
            'pet_shelter' => $pet_shelter,
            'pet' => $pet,
            'subject' => $subject,
        ];
        Mail::to($pet_shelter->email)->send(new SendVolunteerMail($message));
        return 'Successfully send email to volunteer!';
    }
}
