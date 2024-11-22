<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            // Create a user for the doctor
            $user = User::create([
                'name' => fake()->name(),
                'username' => fake()->userName(),
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('password'), // Default password
            ]);

            // Create a doctor linked to the user
            Doctor::create([
                'user_id' => $user->id,
                'license_number' => 'LIC-' . fake()->unique()->randomNumber(6),
                'specialty' => fake()->randomElement(['Cardiology', 'Dermatology', 'Pediatrics', 'Neurology', 'Oncology']),
            ]);
        }
    }
}
