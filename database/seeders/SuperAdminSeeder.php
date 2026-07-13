<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super',
            'firstname' => 'Admin',
            'num_phone' => '0341111110',
            'email' => 'super_admin@gmail.com',
            'password' => Hash::make('123456')
        ]);

        $superAdmin->roles()->create([
            'type' => 'super_admin',
        ]);
    }
}
