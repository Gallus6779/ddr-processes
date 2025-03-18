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

            // \App\Models\Permission::create([
            //     'name' => 'profile.read'
            // ]);

            // \App\Models\Permission::create([
            //     'name' => 'profile.update'
            // ]);

            // \App\Models\Permission::create([
            //     'name' => 'dashboard.read'
            // ]);

            // \App\Models\Permission::create([
            //     'name' => 'imports.read',
            // ]);

            // \App\Models\Permission::firstorcreate([
            //     'name' => 'imports.create',
            // ]);

            $permissions = [
                'roles.create',
                'roles.read',
                'roles.update',
                'roles.delete',
                'profile.read',
                'dashboard.read',
                'imports.create',
                'imports.read',
                'permissions.create',
                'permissions.read',
                'permissions.update',
                'permissions.delete',
                'users.create',
                'users.read',
                'users.update',
                'users.delete',
                'profile.read',
                'profile.update',
                'dashboard.read',
                'customers.read',
                'customers.update',
                'customers.discounts.read',
                'customers.discounts.update',
                'customers.discounts.create',
                'customers.discounts.delete',
                'customers.consumptions.create',
                'customers.consumptions.update',
                'customers.consumptions.read',
                'customers.consumptions.delete',
                'settings.discount_periods.read',
                'settings.discount_periods.create',
                'settings.discount_periods.delete',
                'settings.discount_periods.update'
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
