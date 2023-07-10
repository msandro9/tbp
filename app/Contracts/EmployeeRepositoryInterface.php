<?php

namespace App\Contracts;

interface EmployeeRepositoryInterface
{
    public function getEmployees(): array;

    public function getEmployee($id);

    public function createEmployee($values);

    public function deleteEmployee($id);

    public function updateEmployee($id, $values);

    public function getEmployeesByTeam($teamId);
}
