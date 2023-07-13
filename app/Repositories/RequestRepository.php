<?php

namespace App\Repositories;

use App\Contracts\RequestRepositoryInterface;
use App\Models\PermissionType;
use App\Models\Request;
use App\Models\RequestStatus;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RequestRepository implements RequestRepositoryInterface
{
    public function getRequestsForEmployee($id)
    {
        $requests = DB::select("
            SELECT r.* FROM requests r WHERE employee_id = :id
            ORDER BY created_at
        ", ['id' => $id]);

        return $requests;
    }

    public function createRequest($values)
    {
        $start_date = Carbon::parse($values['start_date']);
        $end_date = Carbon::parse($values['end_date']);
        $values['duration'] = $end_date->diffInWeekdays($start_date);
        $values['employee_id'] = auth()->id();

        DB::statement("
            INSERT INTO requests
            (start_date, end_date, duration, employee_id)
            VALUES
            (:start_date, :end_date, :duration, :employee_id)
        ", $values);
    }

    public function getUpcomingVacationsForTeam($id)
    {
        $requests = DB::select("
            SELECT r.*, e.first_name, e.last_name FROM requests r
            INNER JOIN employees e
            ON r.employee_id = e.id
            WHERE start_date > CURRENT_DATE
            AND e.team_id = :id
            AND status = :status
            AND role = :role
            ORDER BY start_date ASC, end_date DESC
        ", ['id' => $id, 'status' => RequestStatus::ACCEPTED, 'role' => Role::USER]);

        return $requests;
    }

    public function getInProgressVacationsForTeam($id)
    {
        $requests = DB::select("
            SELECT r.*, e.first_name, e.last_name FROM requests r
            INNER JOIN employees e
            ON r.employee_id = e.id
            WHERE r.start_date <= CURRENT_DATE
            AND r.end_date >= CURRENT_DATE
            AND e.team_id = :id
            AND status = :status
            AND role = :role
            ORDER BY end_date, start_date
        ", ['id' => $id, 'status' => RequestStatus::ACCEPTED, 'role' => Role::USER]);

        return $requests;
    }

    public function getRequest($id)
    {
        $request = DB::select("
            SELECT r.*, e.first_name, e.last_name, e.team_id FROM requests r
            INNER JOIN employees e
            ON r.employee_id = e.id
            WHERE r.id = :id
            LIMIT 1
        ", ['id' => $id]);

        return $request[0];
    }

    public function getTeamLeaderPermission($id)
    {
        $permission = DB::select("
            SELECT * FROM permissions
            WHERE request_id = :id
            AND type = :type
            LIMIT 1
        ", ['id' => $id, 'type' => PermissionType::TEAM_LEADER]);

        return $permission[0];
    }

    public function getProjectLeaderPermission($id)
    {
        $permission = DB::select("
            SELECT * FROM permissions
            WHERE request_id = :id
            AND type = :type
            LIMIT 1
        ", ['id' => $id, 'type' => PermissionType::PROJECT_LEADER]);

        return $permission[0];
    }

    public function getPendingTeamRequestsForTeamLeader($id)
    {
        $requests = DB::select("
            SELECT r.*, e.first_name, e.last_name, e.team_id FROM requests r
            INNER JOIN employees e
            ON r.employee_id = e.id
            WHERE r.status = :status
            AND e.team_id = :id
            ORDER BY start_date ASC, end_date DESC
        ", ['id' => $id, 'status' => RequestStatus::PENDING]);

        return $requests;
    }

    public function getPermission($id)
    {
        $permission = DB::select("
            SELECT * FROM permissions
            WHERE id = :id
            LIMIT 1
        ", ['id' => $id]);

        return $permission[0];
    }

    public function updatePermission($id, $values)
    {
        DB::statement("
            UPDATE permissions SET
            accepted = :accepted,
            employee_id = :employee_id,
            note = :note
            WHERE id = :id
        ", $values);
    }
}
