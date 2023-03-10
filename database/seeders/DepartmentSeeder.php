<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $dept = [
            'name' => 'N/A',
        ];
        Department::create($dept);

        $dept = [
            'name' => 'IT',
        ];
        Department::create($dept);
    }
}
