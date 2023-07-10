<?php

namespace App\Repositories;

use App\Contracts\TeamRepositoryInterface;
use Illuminate\Support\Facades\DB;

class TeamRepository implements TeamRepositoryInterface
{
    public function getTeams(): array
    {
        $teams = DB::select("
            SELECT t.id, t.name,
            team_leader_id as tl_id, e1.first_name as tl_fn , e1.last_name as tl_ln,
            project_leader_id as pl_id, e2.first_name as pl_fn, e2.last_name as pl_ln
            FROM teams t
            LEFT JOIN employees e1
            ON team_leader_id = e1.id
            LEFT JOIN employees e2
            ON project_leader_id = e2.id
            ORDER BY t.name
        ");

        return $this->formatRawTeams($teams);
    }

    public function getTeam($id)
    {
        $team = DB::select("
            SELECT t.id, t.name,
            team_leader_id as tl_id, e1.first_name as tl_fn , e1.last_name as tl_ln,
            project_leader_id as pl_id, e2.first_name as pl_fn, e2.last_name as pl_ln
            FROM teams t
            LEFT JOIN employees e1
            ON team_leader_id = e1.id
            LEFT JOIN employees e2
            ON project_leader_id = e2.id
            WHERE t.id = :id
            LIMIT 1
        ", ['id' => $id]);

        return $this->formatRawTeam($team[0]);
    }

    private function formatRawTeams($teams)
    {
        $formattedTeams = [];

        foreach ($teams as $team) {
            $formattedTeams[] = $this->formatRawTeam($team);
        }

        return $formattedTeams;
    }

    private function formatRawTeam($team)
    {
        return $team;
    }
}
