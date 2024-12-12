<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role; // Import Role model
use Spatie\Permission\Models\Permission; // Import Permission model (if you need permissions)

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ensure that the 'panel_admin' role exists in the roles table
        $role = Role::firstOrCreate(['name' => 'super_admin']);

        // Create the user
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'), // Always hash the password
        ]);

        // Assign the 'panel_admin' role to the user
        $user->assignRole($role);
    }
}
