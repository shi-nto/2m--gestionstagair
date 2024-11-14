<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class StagiairesSeeder extends Seeder
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
          // Initial value for id_pers
          $idPersStart = 44;
          $idPersEnd = 1043;
          $idPers = $idPersStart;
          for ($i = 0; $i < 10000; $i++) {
            DB::table('stagiaires')->insert([
                'nom' => $faker->lastName,
                'prenom' => $faker->firstName,
                'cin' => strtoupper(Str::random(8)),
                'gender' => $faker->randomElement([0, 1]), // 0 for female, 1 for male
                'institut' => $faker->company,
                'formation' => $faker->word,
                'gsm' => $faker->phoneNumber,
                'nature_stage' => $faker->randomElement(['observation', 'aplication', 'fin_etudes']),
                'theme' => $faker->sentence,
                'date_debut' => $faker->date('Y-m-d'),
                'date_fin' => $faker->date('Y-m-d'),
                'id_enc' => $faker->numberBetween(2, 392),
                'id_pers' => $idPers,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Increment id_pers, and reset if the end is reached
            $idPers++;
            if ($idPers > $idPersEnd) {
                $idPers = $idPersStart;
            }
        }
    
    }
}
