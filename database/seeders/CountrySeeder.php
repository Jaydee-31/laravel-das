<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['code' => 1010, 'name' => 'Germany', 'language_code' => 'DE'],
            ['code' => 1550, 'name' => 'International', 'language_code' => 'EN'],
            ['code' => 2000, 'name' => 'France', 'language_code' => 'FR'],
            ['code' => 2200, 'name' => 'Austria', 'language_code' => 'DE'],
            ['code' => 2320, 'name' => 'Belgium', 'language_code' => 'EN'],
            ['code' => 2320, 'name' => 'Belgium', 'language_code' => 'NL'],
            ['code' => 2320, 'name' => 'Belgium', 'language_code' => 'FR'],
            ['code' => 2420, 'name' => 'Netherlands', 'language_code' => 'NL'],
            ['code' => 2420, 'name' => 'Netherlands', 'language_code' => 'EN'],
            ['code' => 2510, 'name' => 'United Kingdom', 'language_code' => 'EN'],
            ['code' => 2610, 'name' => 'Spain', 'language_code' => 'ES'],
            ['code' => 2640, 'name' => 'Portugal', 'language_code' => 'PT'],
            ['code' => 2710, 'name' => 'Italy', 'language_code' => 'IT'],
            ['code' => 2800, 'name' => 'Denmark', 'language_code' => 'DK'],
            ['code' => 2800, 'name' => 'Denmark', 'language_code' => 'EN'],
            ['code' => 2900, 'name' => 'Norway', 'language_code' => 'NO'],
            ['code' => 2900, 'name' => 'Norway', 'language_code' => 'EN'],
            ['code' => 3100, 'name' => 'Sweden', 'language_code' => 'SE'],
            ['code' => 3100, 'name' => 'Sweden', 'language_code' => 'EN'],
            ['code' => 5110, 'name' => 'Estonia', 'language_code' => 'EE'],
            ['code' => 5210, 'name' => 'Latvia', 'language_code' => 'LV'],
            ['code' => 5310, 'name' => 'Lithuania', 'language_code' => 'LT'],
            ['code' => 5410, 'name' => 'Poland', 'language_code' => 'PL'],
            ['code' => 5710, 'name' => 'Finland', 'language_code' => 'FI'],
            ['code' => 5710, 'name' => 'Finland', 'language_code' => 'EN'],
            ['code' => 5820, 'name' => 'Slovenia', 'language_code' => 'SI'],
            ['code' => 5830, 'name' => 'Croatia', 'language_code' => 'HR'],
            ['code' => 5840, 'name' => 'Slovakia', 'language_code' => 'SK'],
            ['code' => 5845, 'name' => 'Czech Republic', 'language_code' => 'CZ'],
            ['code' => 5850, 'name' => 'Hungary', 'language_code' => 'HU'],
            ['code' => 5860, 'name' => 'Romania', 'language_code' => 'RO'],
            ['code' => 5870, 'name' => 'Bulgaria', 'language_code' => 'BG'],
            ['code' => 5881, 'name' => 'Serbia', 'language_code' => 'SR'],
            ['code' => 5895, 'name' => 'Montenegro', 'language_code' => 'ME'],
            ['code' => 6000, 'name' => 'International', 'language_code' => 'EN'],
            ['code' => 6110, 'name' => 'Switzerland', 'language_code' => 'DE'],
            ['code' => 6110, 'name' => 'Switzerland', 'language_code' => 'FR'],
        ];

        DB::table('countries')->insert($data);
    }
}
