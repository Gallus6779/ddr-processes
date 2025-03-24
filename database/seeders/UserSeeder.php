<?php

namespace Database\Seeders;

use App\Models\CustomerType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CustomerType::firstOrCreate([
            'name' => 'Particulier'
        ]);
        DB::transaction(function () {
            \App\Models\User::firstOrCreate([
                'email' => 'admin@local.test'
            ],
            [
                'name' => 'Administrator',
                'email' => 'admin@local.test',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now()
            ]);

            \App\Models\Role::firstOrCreate([
                'name' => 'administrator'
            ],[
                'name' => 'administrator'
            ]);
        });
    }
}
