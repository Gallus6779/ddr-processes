<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
