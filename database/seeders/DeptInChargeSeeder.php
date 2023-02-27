<?php

namespace Database\Seeders;

use App\Models\DeptInCharge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeptInChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deptInCharge = [
            'dept_id' => '1',
        ];
        DeptInCharge::create($deptInCharge);
    }
}
