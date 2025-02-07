<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Weighing;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::insert([
            ['name' => 'Tri Sunu Hardi', 'username' => 'sunu', 'password' => bcrypt('sunu_kba')],
            ['name' => 'Sri Winarno', 'username' => 'win', 'password' => bcrypt('win_kba')],
            ['name' => 'Tataq Seviarto', 'username' => 'tataq', 'password' => bcrypt('tataq_kba')],
            ['name' => 'Vicky Dwi Putra', 'username' => 'vicky', 'password' => bcrypt('vicky_kba')],
        ]);

        for ($i = 0; $i < 1000; $i++) {
            $lines = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'];
            $randomLine = $lines[array_rand($lines)];
            Weighing::insert([
                'line' => $randomLine,
                'setting' => 50,
                'result' => '50.' . $i,
            ]);
        }
    }
}
