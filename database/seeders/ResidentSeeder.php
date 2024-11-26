<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Residents;

class ResidentSeeder extends Seeder
{
    public function run()
    {
        Residents::factory(100)->create();
    }
}
