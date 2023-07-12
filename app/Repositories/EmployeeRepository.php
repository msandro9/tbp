<?php

namespace App\Repositories;

use App\Contracts\EmployeeRepositoryInterface;
use App\Helper\Helper;
use App\Models\Employee;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function getEmployees(): array
    {
        $employees = DB::select("
            SELECT e.id, first_name, last_name, role, email, address, vacation_days, team_id, t.name as team_name
            FROM employees e
            LEFT JOIN teams t
            ON team_id = t.id
            ORDER BY last_name, first_name
        ");

        return $this->formatRawEmployees($employees);
    }

    public function getEmployee($id)
    {
        $employee = DB::select("
            SELECT e.id, first_name, last_name, role, email, address, vacation_days, team_id, t.name as team_name
            FROM employees e
            LEFT JOIN teams t
            ON team_id = t.id
            WHERE e.id = :id
            LIMIT 1
        ", ['id' => $id]);

        return $this->formatRawEmployee($employee[0]);
    }

    private function formatRawEmployees($employees)
    {
        $formattedEmployees = [];

        foreach ($employees as $employee) {
            $formattedEmployees[] = $this->formatRawEmployee($employee);
        }

        return $formattedEmployees;
    }

    private function formatRawEmployee($employee)
    {
        $employee->address = Helper::formatAddressToArray($employee->address);

        return $employee;
    }

    public function createEmployee($values)
    {
        $query = "
            INSERT INTO employees
            (first_name, last_name, email, role, password, address)
            VALUES
            (:first_name, :last_name, :email, :role, :password, ROW(:street, :number, :postal_code, :city, :country))
        ";

        DB::statement($query, $values);
    }

    public function deleteEmployee($id)
    {
        DB::statement("
            DELETE FROM employees WHERE id = :id
        ", ['id' => $id]);
    }

    public function updateEmployee($id, $values)
    {
        $values['id'] = $id;

        DB::statement("
            UPDATE employees SET
            team_id = :team_id,
            vacation_days = :vacation_days
            WHERE id = :id;
        ", $values);
    }

    public function getEmployeesByTeam($teamId)
    {
        $employees = DB::select("
            SELECT e.id, first_name, last_name, role, email, address, vacation_days, team_id, t.name as team_name
            FROM employees e
            INNER JOIN teams t
            ON team_id = t.id
            WHERE t.id = :teamId
            AND (t.team_leader_id IS NULL OR e.id != t.team_leader_id)
            AND (t.project_leader_id IS NULL OR e.id != t.project_leader_id)
            ORDER BY last_name, first_name
        ", ['teamId' => $teamId]);

        return $this->formatRawEmployees($employees);
    }

    public function getTeamLeader($id)
    {
        $employee = DB::select("
            SELECT id, first_name, last_name, role
            FROM employees e
            WHERE team_id = :id
            AND role = :role
            LIMIT 1
        ", ['id' => $id, 'role' => Role::TEAM_LEADER]);

        if (empty($employee)) {
            return null;
        }

        return $employee[0];
    }

    public function getProjectLeader($id)
    {
        $employee = DB::select("
            SELECT id, first_name, last_name, role
            FROM employees e
            WHERE team_id = :id
            AND role = :role
            LIMIT 1
        ", ['id' => $id, 'role' => Role::PROJECT_LEADER]);

        if (empty($employee)) {
            return null;
        }

        return $employee[0];
    }
}
