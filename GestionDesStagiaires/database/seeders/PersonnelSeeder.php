<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
class PersonnelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         //
         $faker = Faker::create();
         $data = [];
 
         for ($i = 0; $i < 10000; $i++) {
             $data[] = [
                 'id_enc' => $faker->numberBetween(2, 392), // Assuming you have 10 encadrants
             ];
         }
 
         DB::table('personnel')->insert($data);
     
     
    }
}
