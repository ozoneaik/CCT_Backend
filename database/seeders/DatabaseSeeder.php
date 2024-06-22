<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run() : void
    {
        // \App\Models\User::factory(10)->create();

         User::create([
             'username' => '70010',
             'password' => Hash::make('1111'),
             'name' => 'ภูวเดช พาณิชยโสภา'
         ]);
        User::create([
            'username' => 'admin',
            'password' => Hash::make('1111'),
            'name' => 'แอดมิน'
        ]);
    }
}
