<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
    
        $this->call(UserSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(CustomerTypeSeeder::class);
    }
}
