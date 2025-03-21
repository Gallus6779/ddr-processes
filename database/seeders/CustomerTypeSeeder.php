<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customerTypes = [
            'Individual',
            'Company'
    ];

        foreach($customerTypes as $customerTypes){
            
            
            \App\Models\CustomerType::firstOrCreate([
                'name' => $customerTypes
            ],[
                'name' => $customerTypes
            ]);

        }
    }
}
