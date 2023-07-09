<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Team;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([AdministratorSeeder::class]);

        $teams = Team::factory(5)->create();

        foreach ($teams as $team) {
            $this->callWith(EmployeeSeeder::class, ['team_id' => $team->id]);
            $this->callWith(TeamLeadersSeeder::class, ['team' => $team]);
        }
    }
}
