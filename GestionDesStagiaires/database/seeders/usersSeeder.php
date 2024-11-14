<?php
// database/seeders/StagiairesSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\users;


class usersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

   
        users::create([
            'first_name' => 'admin',
            'second_name' => 'admin',
            'userName' => 'admin',
            'role' =>1,
            'password' => bcrypt('@soread2mAdmin2024'), // Hash the password
        ]);
        }
    
}
