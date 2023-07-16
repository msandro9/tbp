<?php

namespace App\Contracts;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

interface EmployeeRepositoryInterface
{
    public function getEmployees(): array;

    public function getEmployee($id);

    public function createEmployee($values);

    public function deleteEmployee($id);

    public function updateEmployee($id, $values);

    public function getEmployeesByTeam($teamId);

    public function getTeamLeader($id);

    public function getProjectLeader($id);

    public function updateProfile($values);
}
