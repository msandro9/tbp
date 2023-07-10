<?php

namespace App\Contracts;

interface TeamRepositoryInterface
{
    public function getTeams(): array;

    public function getTeam($id);
}
