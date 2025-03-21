<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    private const CRUD_DEF = [
        'create',
        'read',
        'update',
        'delete'
    ];

    private const DEFAULT_CRUD_RESOURCES = [
        'roles',
        'permissions',
        'users',
    ];

    public function run(): void
    {
        DB::transaction(function () {
            for ($i = 0; $i < count(self::DEFAULT_CRUD_RESOURCES); $i++) {
                for ($j = 0; $j < count(self::CRUD_DEF); $j++) {
                    \App\Models\Permission::create([
                        'name' => self::DEFAULT_CRUD_RESOURCES[$i] . '.' . self::CRUD_DEF[$j]
                    ]);
                }
            }

            $permissions = [
                'dashboard.read',
                'users.create',
                'users.read',
                'users.update',
                'users.delete',
                'profile.read',
                'profile.update',
                'imports.create',
                'imports.read',
                'discounts.read',
                'discounts.discounts.read',
                'discounts.discounts.update',
                'discounts.discounts.create',
                'discounts.discounts.delete',
                'discounts.consumptions.create',
                'discounts.consumptions.update',
                'discounts.consumptions.read',
                'discounts.consumptions.delete',
                'discounts.discount_periods.read',
                'discounts.discount_periods.create',
                'discounts.discount_periods.delete',
                'discounts.discount_periods.update',
                
                'discounts.customers.read',
                'discounts.customers.create',
                'discounts.customers.update',
                'discounts.customers.delete',

                'settings.districts.create',
                'settings.districts.read',
                'settings.districts.update',
                'settings.districts.delete',
                'settings.stations.create',
                'settings.stations.read',
                'settings.stations.update',
                'settings.stations.delete',
                'settings.roles.create',
                'settings.roles.read',
                'settings.roles.update',
                'settings.roles.delete',
                'settings.permissions.create',
                'settings.permissions.read',
                'settings.permissions.update',
                'settings.permissions.delete'
        ];

            foreach($permissions as $permission){
                
                
                \App\Models\Permission::firstOrCreate([
                    'name' => $permission
                ],[
                    'name' => $permission
                ]);

                // \App\Models\Permission::create(['name' => $permission]);
            }

        });
    }
}
