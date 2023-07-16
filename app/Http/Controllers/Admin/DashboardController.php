<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\EmployeeRepositoryInterface;
use App\Contracts\RequestRepositoryInterface;
use App\Contracts\TeamRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\RequestStatus;
use App\Models\Role;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private RequestRepositoryInterface $requestRepository;
    private EmployeeRepositoryInterface $employeeRepository;
    private TeamRepositoryInterface $teamRepository;

    public function __construct(RequestRepositoryInterface  $requestRepository,
                                EmployeeRepositoryInterface $employeeRepository,
                                TeamRepositoryInterface     $teamRepository,
    )
    {
        $this->requestRepository = $requestRepository;
        $this->employeeRepository = $employeeRepository;
        $this->teamRepository = $teamRepository;
    }

    public function index()
    {
        return view('admin.dashboard', [
            'total_employees' => DB::select("SELECT COUNT(*) AS count FROM employees")[0]->count,
            'total_teams' => DB::select("SELECT COUNT(*) AS count FROM teams")[0]->count,
            'total_pending_requests' => DB::select("SELECT COUNT(*) AS count FROM requests WHERE status = :pending", ['pending' => RequestStatus::PENDING])[0]->count,
            'total_accepted_requests' => DB::select("SELECT COUNT(*) AS count FROM requests WHERE status = :accepted", ['accepted' => RequestStatus::ACCEPTED])[0]->count,
            'total_declined_requests' => DB::select("SELECT COUNT(*) AS count FROM requests WHERE status = :declined", ['declined' => RequestStatus::DECLINED])[0]->count,
        ]);
    }
}
