<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('leave_types')->insert([
            [
                'id' => 1,
                'name' => 'Annual Leave',
                'max_days_per_year' => 21,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Sick Leave',
                'max_days_per_year' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Maternity Leave',
                'max_days_per_year' => 90,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Unpaid Leave',
                'max_days_per_year' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'Emergency Leave',
                'max_days_per_year' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
