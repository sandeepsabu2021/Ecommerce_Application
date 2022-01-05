<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Super Admin', 'Admin', 'Inventory Manager', 'Order Manager', 'Customer'];
        foreach($roles as $r){
            $role = new Role();
            $role->role_name = $r;
            $role->save();
        }
    }
}
