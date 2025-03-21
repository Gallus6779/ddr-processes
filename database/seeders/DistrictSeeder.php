<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = array(
            [
                'name' => 'LITTORAL OUEST SUD-OUEST',
                'acronym' => 'LOSO'
            ],
            [
                'name' => 'DISTRICT CENTRE SUD EST',
                'acronym' => 'DCSE'
            ]
        );

        for($i=0; $i < count($districts);$i++){

            \App\Models\District::firstOrCreate([
                'name' => $districts[$i]['name']
            ],[
                'name' => $districts[$i]['name'],
                'acronym' => $districts[$i]['acronym'],
                'created_by' => 1,
                'validated_by' => 1
            ]);
        }
    }
}
