<?php

namespace App\Repositories;

use App\Contracts\TeamRepositoryInterface;
use App\Models\Role;
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

    public function createTeam($values)
    {
        DB::statement("
            INSERT INTO TEAMS
            (name)
            VALUES
            (:name)
        ", $values);
    }

    public function deleteTeam($id)
    {
        DB::statement("
            DELETE FROM teams WHERE id = :id
        ", ['id' => $id]);
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

    public function updateTeam($values)
    {
        $old_tl = $values['old_team_leader_id'];
        $tl = $values['team_leader_id'];

        $old_pl = $values['old_project_leader_id'];
        $pl = $values['project_leader_id'];

        $team_id = $values['team_id'];

        DB::beginTransaction();

        try {
            if ($old_tl != $tl) {
                DB::statement("
                    UPDATE employees SET role = :role WHERE id = :id
                ", ['role' => Role::USER, 'id' => $old_tl]);

                DB::statement("
                    UPDATE employees SET role = :role WHERE id = :id
                ", ['role' => Role::TEAM_LEADER, 'id' => $tl]);
            }

            if ($old_pl != $pl) {
                DB::statement("
                    UPDATE employees SET role = :role WHERE id = :id
                ", ['role' => Role::USER, 'id' => $old_pl]);

                DB::statement("
                    UPDATE employees SET role = :role WHERE id = :id
                ", ['role' => Role::PROJECT_LEADER, 'id' => $pl]);
            }

            DB::statement("
                UPDATE teams SET team_leader_id = :tl_id, project_leader_id = :pl_id WHERE id = :id
            ", ['id' => $team_id, 'tl_id' => $tl, 'pl_id' => $pl]);

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
