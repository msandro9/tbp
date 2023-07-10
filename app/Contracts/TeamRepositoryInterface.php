<?php

namespace App\Contracts;

use Illuminate\Support\Facades\DB;

interface TeamRepositoryInterface
{
    public function getTeams(): array;

    public function getTeam($id);

    public function createTeam($values);

    public function deleteTeam($id);

    public function updateTeam($values);
}
