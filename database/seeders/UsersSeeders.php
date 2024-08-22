<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                "name" => 'Damianus',
                "email" => 'dean@gmail.com',
                'role' => 'operator',
                'password' => bcrypt('Batikan56')
            ],
            [
                "name" => 'Muji',
                "email" => 'muji@gmail.com',
                'role' => 'petani',
                'password' => bcrypt('Batikan56')
            ]
        ];

        foreach ($userData as $key => $val) {
            User::create($val);
        }
    }
}
