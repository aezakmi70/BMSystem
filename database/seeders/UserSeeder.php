<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'completeName' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => 'admin', // Automatically hashed because of model's cast
        ]);
    }
}
