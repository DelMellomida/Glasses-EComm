<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userDetail = [
            [
                'user_id' => 1,
                'address' => '',
                'phone_number' => '',
                'gender' => 'male',
                'date_of_birth' => null,
            ],
            [
                'user_id' => 2,
                'address' => '',
                'phone_number' => '',
                'gender' => 'male',
                'date_of_birth' => null,
            ]
        ];

        foreach ($userDetail as $detail) {
            \App\Models\UserDetails::create($detail);
        }
    }
}
