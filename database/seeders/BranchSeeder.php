<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'branch_name' => 'R. Sarabia Optical – Sta. Elena Branch',
                'branch_address' => '#187 Shoe. Ave. Brgy. Sta Elena, Marikina City',
                'branch_phone' => '027956-6679',
            ],
            [
                'branch_name' => 'R. Sarabia Optical – Phil. Trust Branch',
                'branch_address' => '#23 Phil. Trust Bank Bldg. Sumulong Hi-way cor. P. Burgos St. Brgy. Sto. Nino, Marikina City',
                'branch_phone' => '027949-0061',
            ],
            [
                'branch_name' => 'R. Sarabia Optical – Pasig Branch',
                'branch_address' => '#34-A Mabini St. Brgy. Kapasigan, Pasig City',
                'branch_phone' => '027002-2998',
            ],
            [
                'branch_name' => 'R. Sarabia Optical – Masinag Branch',
                'branch_address' => '#272 Sumulong Hi-way Brgy. Mayamot, Antipolo City',
                'branch_phone' => '088470-8822',
            ],
            [
                'branch_name' => 'R. Sarabia Optical – SM Center Downtown Antipolo',
                'branch_address' => '2nd floor SM Center Downtown Antipolo, Marcos Hi-way Brgy. Mayamot, Antipolo City',
                'branch_phone' => '028330-7791',
            ],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}