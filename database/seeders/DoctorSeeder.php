<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        for ($i = 0; $i < 10; $i++) {
//            // Create a user for the doctor
//            $user = User::create([
//                'name' => fake()->name(),
//                'username' => fake()->userName(),
//                'email' => fake()->unique()->safeEmail(),
//                'password' => bcrypt('password'), // Default password
//            ]);
//
//            // Create a doctor linked to the user
//            Doctor::create([
//                'user_id' => $user->id,
//                'license_number' => 'LIC-' . fake()->unique()->randomNumber(6),
//                'specialty' => fake()->randomElement(['Cardiology', 'Dermatology', 'Pediatrics', 'Neurology', 'Oncology']),
//            ]);
//        }

        $doctors = [
            [
                'name' => 'DR. LESLIE JOAN TAULI',
                'email' => 'leslietauli@example.com',
                'password' => bcrypt('password'),
                'contact_number' => '09778407129',
                'specialty' => 'Physician',
                'schedules' => [
                    ['day' => 'Monday', 'start_time' => '08:00:00', 'end_time' => '16:30:00'],
                    ['day' => 'Tuesday', 'start_time' => '08:00:00', 'end_time' => '16:30:00'],
                    ['day' => 'Thursday', 'start_time' => '08:00:00', 'end_time' => '16:30:00'],
                    ['day' => 'Friday', 'start_time' => '08:00:00', 'end_time' => '16:30:00'],
                    ['day' => 'Saturday', 'start_time' => '08:00:00', 'end_time' => '16:30:00'],
                ],
            ],
            [
                'name' => 'DR. FRETZENE ARANCES',
                'email' => 'fretzenearances@example.com',
                'password' => bcrypt('password'),
                'contact_number' => '09778407129',
                'specialty' => 'Physician',
                'schedules' => [
                    ['day' => 'Monday', 'start_time' => '08:00:00', 'end_time' => '16:30:00'],
                    ['day' => 'Tuesday', 'start_time' => '08:00:00', 'end_time' => '16:30:00'],
                    ['day' => 'Thursday', 'start_time' => '08:00:00', 'end_time' => '16:30:00'],
                    ['day' => 'Friday', 'start_time' => '08:00:00', 'end_time' => '16:30:00'],
                    ['day' => 'Saturday', 'start_time' => '08:00:00', 'end_time' => '16:30:00'],
                ],
            ],
            [
                'name' => 'DR. HOPE LAROT',
                'email' => 'hopelarot@example.com',
                'password' => bcrypt('password'),
                'contact_number' => '09778407129',
                'specialty' => 'Physician',
                'schedules' => [
                    ['day' => 'Wednesday', 'start_time' => '08:00:00', 'end_time' => '16:30:00'],
                    ['day' => 'Friday', 'start_time' => '08:00:00', 'end_time' => '16:30:00'],
                    ['day' => 'Saturday', 'start_time' => '08:00:00', 'end_time' => '16:30:00'],
                ],
            ],
            [
                'name' => 'DR. ALLAN MELICOR',
                'email' => 'allanmelicor@example.com',
                'password' => bcrypt('password'),
                'contact_number' => '09778407129',
                'specialty' => 'Physician',
                'schedules' => [
                    ['day' => 'By Appointment', 'start_time' => '', 'end_time' => ''],
                ],
            ],
            [
                'name' => 'DR. PAMELA RUTH MOHAN',
                'email' => 'pamelaruthmohan@example.com',
                'password' => bcrypt('password'),
                'contact_number' => '09973828368',
                'specialty' => 'Internal Medicine',
                'schedules' => [
                    ['day' => 'Monday', 'start_time' => '13:00:00', 'end_time' => '17:00:00'],
                    ['day' => 'Friday', 'start_time' => '13:00:00', 'end_time' => '17:00:00'],
                    ['day' => 'Wednesday', 'start_time' => '09:00:00', 'end_time' => '12:00:00'],
                ],
            ],
            [
                'name' => 'DR. MARY JANE DEL MUNDO',
                'email' => 'maryjanedelmundo@example.com',
                'password' => bcrypt('password'),
                'contact_number' => '09353730252',
                'specialty' => 'Family & Community Medicine/Ambulatory Diabetes',
                'schedules' => [
                    ['day' => 'Monday', 'start_time' => '10:00:00', 'end_time' => '14:00:00'],
                    ['day' => 'Tuesday', 'start_time' => '10:00:00', 'end_time' => '14:00:00'],
                    ['day' => 'Thursday', 'start_time' => '10:00:00', 'end_time' => '14:00:00'],
                    ['day' => 'Friday', 'start_time' => '10:00:00', 'end_time' => '14:00:00'],
                ],
            ],
            [
                'name' => 'DR. ROBERT CHAVEZ',
                'email' => 'robertchavez@example.com',
                'password' => bcrypt('password'),
                'contact_number' => '09275904459',
                'specialty' => 'ENT',
                'schedules' => [
                    ['day' => 'Monday', 'start_time' => '10:00:00', 'end_time' => '12:00:00'],
                    ['day' => 'Tuesday', 'start_time' => '10:00:00', 'end_time' => '12:00:00'],
                    ['day' => 'Thursday', 'start_time' => '10:00:00', 'end_time' => '12:00:00'],
                    ['day' => 'Friday', 'start_time' => '10:00:00', 'end_time' => '12:00:00'],
                    ['day' => 'Saturday', 'start_time' => '10:00:00', 'end_time' => '12:00:00'],
                ],
            ],
            [
                'name' => 'DR. ROY SASIL',
                'email' => 'roysasil@example.com',
                'password' => bcrypt('password'),
                'contact_number' => '09653454021',
                'specialty' => 'Adult Cardiology',
                'schedules' => [
                    ['day' => 'By Appointment', 'start_time' => '', 'end_time' => ''],
                ],
            ],
            [
                'name' => 'DR. ADONIS LATAYAN',
                'email' => 'adonislatayan@example.com',
                'password' => bcrypt('password'),
                'contact_number' => '09653454021',
                'specialty' => 'Urology',
                'schedules' => [
                    ['day' => 'Thursday', 'start_time' => '09:00:00', 'end_time' => '12:00:00'],
                ],
            ],
            [
                'name' => 'DR. DEAN MARVIN EDUAVE',
                'email' => 'deanmarvineduave@example.com',
                'password' => bcrypt('password'),
                'contact_number' => '09359506196',
                'specialty' => 'Urology',
                'schedules' => [
                    ['day' => 'By Appointment', 'start_time' => '', 'end_time' => ''],
                ],
            ],
            [
                'name' => 'DR. EDWARD ARREZA',
                'email' => 'edwardarreza@example.com',
                'password' => bcrypt('password'),
                'contact_number' => '09359506196',
                'specialty' => 'Orthopedics-Spine Surgery',
                'schedules' => [
                    ['day' => 'Monday', 'start_time' => '', 'end_time' => ''],
                ],
            ],
            [
                'name' => 'DR. AILEEN DUMBRIGUE',
                'email' => 'aileendumbrigue@example.com',
                'password' => bcrypt('password'),
                'contact_number' => '09353730252',
                'specialty' => 'Pediatrics',
                'schedules' => [
                    ['day' => 'Monday', 'start_time' => '10:00:00', 'end_time' => ''],
                    ['day' => 'Tuesday', 'start_time' => '10:00:00', 'end_time' => ''],
                    ['day' => 'Wednesday', 'start_time' => '10:00:00', 'end_time' => ''],
                    ['day' => 'Friday', 'start_time' => '10:00:00', 'end_time' => ''],
                    ['day' => 'Saturday', 'start_time' => '10:00:00', 'end_time' => ''],
                ],
            ],
            [
                'name' => 'DR. AIMEE TZETIEL BERMEO',
                'email' => 'aimeebermeo@example.com',
                'password' => bcrypt('password'),
                'contact_number' => '0997-8225234',
                'specialty' => 'Pediatrics',
                'schedules' => [
                    ['day' => 'Monday', 'start_time' => '10:00:00', 'end_time' => '13:00:00'],
                    ['day' => 'Tuesday', 'start_time' => '10:00:00', 'end_time' => '13:00:00'],
                    ['day' => 'Wednesday', 'start_time' => '10:00:00', 'end_time' => '13:00:00'],
                    ['day' => 'Thursday', 'start_time' => '10:00:00', 'end_time' => '13:00:00'],
                    ['day' => 'Friday', 'start_time' => '10:00:00', 'end_time' => '13:00:00'],
                ]
            ],
            [
                'name' => 'DR. BRENDA TRICIA CATALON',
                'email' => 'brendatriciacatalon@example.com',
                'password' => bcrypt('password'),
                'contact_number' => '09359506196',
                'specialty' => 'Pediatrics',
                'schedules' => [
                    ['day' => 'Monday', 'start_time' => '10:00:00', 'end_time' => '13:00:00'],
                    ['day' => 'Tuesday', 'start_time' => '10:00:00', 'end_time' => '13:00:00'],
                    ['day' => 'Wednesday', 'start_time' => '10:00:00', 'end_time' => '13:00:00'],
                    ['day' => 'Friday', 'start_time' => '10:00:00', 'end_time' => '13:00:00'],
                ],
            ],
            [
                'name' => 'DR. YBETTE PALLASIGUE',
                'email' => 'ybettepallasigue@example.com',
                'password' => bcrypt('password'),
                'contact_number' => '09353730252',
                'specialty' => 'Obstetrics & Gynecology',
                'schedules' => [
                    ['day' => 'Monday', 'start_time' => '10:00:00', 'end_time' => '12:00:00'],
                    ['day' => 'Tuesday', 'start_time' => '10:00:00', 'end_time' => '12:00:00'],
                    ['day' => 'Wednesday', 'start_time' => '10:00:00', 'end_time' => '12:00:00'],
                    ['day' => 'Thursday', 'start_time' => '10:00:00', 'end_time' => '12:00:00'],
                    ['day' => 'Friday', 'start_time' => '10:00:00', 'end_time' => '12:00:00'],
                ],
            ],
            [
                'name' => 'DR. EMELGRACE RODA',
                'email' => 'emelgraceroda@example.com',
                'password' => bcrypt('password'),
                'contact_number' => '09359506196',
                'specialty' => 'Obstetrics & Gynecology',
                'schedules' => [
                    ['day' => 'Monday', 'start_time' => '09:00:00', 'end_time' => '13:00:00'],
                    ['day' => 'Wednesday', 'start_time' => '09:00:00', 'end_time' => '13:00:00'],
                    ['day' => 'Thursday', 'start_time' => '09:00:00', 'end_time' => '13:00:00'],
                    ['day' => 'Saturday', 'start_time' => '09:00:00', 'end_time' => '13:00:00'],
                ],
            ],
            [
                'name' => 'DR. JANET MOLINA',
                'email' => 'janetmolina@example.com',
                'password' => bcrypt('password'),
                'contact_number' => '09455461334',
                'specialty' => 'General Surgery',
                'schedules' => [
                    ['day' => 'Monday', 'start_time' => '09:00:00', 'end_time' => '12:00:00'],
                    ['day' => 'Wednesday', 'start_time' => '09:00:00', 'end_time' => '12:00:00'],
                    ['day' => 'Thursday', 'start_time' => '09:00:00', 'end_time' => '12:00:00'],
                ],
            ],
            [
                'name' => 'DR. BRIAN DUMAGAD',
                'email' => 'briandumagad@example.com',
                'password' => bcrypt('password'),
                'contact_number' => '09653454021',
                'specialty' => 'General Surgery',
                'schedules' => [
                    ['day' => 'Tuesday', 'start_time' => '10:00:00', 'end_time' => '12:00:00'],
                    ['day' => 'Saturday', 'start_time' => '10:00:00', 'end_time' => '12:00:00'],
                ],
            ],
            [
                'name' => 'DR. ALFRED CREDO RUBIO',
                'email' => 'alfredrubio@example.com',
                'password' => bcrypt('password'),
                'contact_number' => '09653454021',
                'specialty' => 'Orthopedics',
                'schedules' => [
                    ['day' => 'Thursday', 'start_time' => '', 'end_time' => ''],
                    ['day' => 'Friday', 'start_time' => '14:00:00', 'end_time' => '16:00:00'],
                ],
            ],
        ];


        foreach ($doctors as $doctorData) {
            $user = User::create([
                'name' => $doctorData['name'],
                'username' => str_replace(' ', '', strtolower($doctorData['name'])),
                'email' => $doctorData['email'],
                'password' => $doctorData['password'],
            ]);

            $doctor = Doctor::create([
                'user_id' => $user->id,
                'specialty' => $doctorData['specialty'],
            ]);

            foreach ($doctorData['schedules'] as $scheduleData) {
                $doctor->schedules()->create($scheduleData);
            }
        }
    }
}
