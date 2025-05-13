<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Products = ['Petrole','Super','Gasoil'] ;

        foreach($Products as $product)
        {
            \App\Models\Product::firstOrCreate([
                'name' => $product
            ]);
        }
    }
}
