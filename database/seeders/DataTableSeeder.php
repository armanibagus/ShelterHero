<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'identityNumber' => 5170134243710000009,
            'username' => 'alexjobs',
            'password' => Hash::make('12345678'),
            'name' => 'Alex Jobs',
            'dateOfBirth' => '2000-10-17',
            'phoneNumber' => '+8209210087001',
            'address' => 'Jl Kenangan, Gang Cempaka No. 66',
            'email' => 'heavenlysins77@gmail.com',
            'email_verified_at' => '2022-04-06 12:37:30',
            'role' => 'user',
        ]);
        User::create([
            'identityNumber' => 29329732912,
            'username' => 'xavieree',
            'password' => Hash::make('87654321'),
            'name' => 'Xavier Putra',
            'phoneNumber' => '+8276519054376',
            'address' => 'Jl Raya Darmasaba No.86',
            'email' => 'xavierjeonjjk@gmail.com',
            'email_verified_at' => '2022-04-06 12:37:30',
            'role' => 'volunteer',
        ]);
        User::create([
            'identityNumber' => 89023712921,
            'username' => 'cahayashelter',
            'password' => Hash::make('cahayapeduli'),
            'name' => 'Cahaya Pet Shelter',
            'phoneNumber' => '+8209865328901',
            'address' => 'Jl Raya Kuta Utara No.12',
            'email' => 'heyitsc03@gmail.com',
            'email_verified_at' => '2022-04-06 12:37:30',
            'role' => 'pet_shelter',
        ]);
    }
}
