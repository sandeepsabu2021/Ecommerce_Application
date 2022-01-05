<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->first_name = "Admin";
        $user->last_name = "admin";
        $user->email = "testsandeep404@gmail.com";
        $user->status = 1;
        $user->role = 1;
        $user->password = Hash::make("admin123");
        $user->save();
    }
}
