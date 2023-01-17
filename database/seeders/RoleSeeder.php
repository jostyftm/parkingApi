<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    private $roles = [
        'client',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create([
            'name'  => 'admin',
            'guard_name'    => 'sanctum'
        ]);

        $employeeRole = Role::create([
            'name'          => 'employee',
            'guard_name'    => 'sanctum'
        ]);
        
        $allPermission = Permission::create([
            'name'  => '*',
            'guard_name'    => 'sanctum' 
        ]);

        $adminRole->givePermissionTo($allPermission);
        $employeeRole->givePermissionTo($allPermission);

        foreach($this->roles as $rol){
            Role::create([
                'name'          => $rol,
                'guard_name'    => 'sanctum'
            ]);
        }
    }
}
