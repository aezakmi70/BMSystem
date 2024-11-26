<?php

namespace Database\Factories;

use App\Models\Residents;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResidentsFactory extends Factory
{
    protected $model = Residents::class;

    public function definition()
    {
        return [
            'lastname' => $this->faker->lastName,
            'firstname' => $this->faker->firstName,
            'middlename' => $this->faker->lastName,
            'birthdate' => $this->faker->date,
            'birthplace' => $this->faker->city,
            'age' => $this->faker->numberBetween(18, 70),
            'barangay' => $this->faker->city,
            'purok' => $this->faker->numberBetween(1,7),
            'differentlyabledperson' => $this->faker->optional()->word,
            'maritalstatus' => $this->faker->word,
            'bloodtype' => $this->faker->bloodType,
            'occupation' => $this->faker->jobTitle,
            'monthlyincome' => $this->faker->numberBetween(5000, 10000),
            'religion' => $this->faker->optional()->word,
            'nationality' => $this->faker->word,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'igpitID' => $this->faker->optional()->randomNumber(),
            'philhealthNo' => $this->faker->unique()->numerify('#########'), // Exactly 12 digits
            'contactNumber' => $this->faker->numerify('09#########'), // 11-digit phone number
        ];
    }
}
