<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Role;
use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamLeadersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Team $team): void
    {
        $teamLeader = Employee::query()->where('team_id', $team->id)
            ->where('role', Role::TEAM_LEADER)
            ->first();

        $projectLeader = Employee::query()->where('team_id', $team->id)
            ->where('role', Role::PROJECT_LEADER)
            ->first();

        $team->team_leader_id = $teamLeader->id;
        $team->project_leader_id = $projectLeader->id;
        $team->save();
    }
}
