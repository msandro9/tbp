<?php

namespace App\Contracts;

use App\Models\RequestStatus;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

interface RequestRepositoryInterface
{
    public function getRequestsForEmployee($id);

    public function createRequest($values);

    public function getUpcomingVacationsForTeam($id);

    public function getInProgressVacationsForTeam($id);

    public function getRequest($id);

    public function getPendingTeamRequestsForTeamLeader($id);

    public function getTeamLeaderPermission($id);

    public function getProjectLeaderPermission($id);

    public function getPermission($id);
}
