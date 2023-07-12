<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run($team_id): void
    {
        Employee::factory()->create([
            'role' => Role::TEAM_LEADER,
            'team_id' => $team_id
        ]);
        Employee::factory()->create([
            'role' => Role::PROJECT_LEADER,
            'team_id' => $team_id
        ]);
        Employee::factory(6)->create([
            'team_id' => $team_id
        ]);
    }
}
