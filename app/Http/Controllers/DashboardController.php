<?php

namespace App\Http\Controllers;

use App\Contracts\EmployeeRepositoryInterface;
use App\Contracts\RequestRepositoryInterface;
use App\Models\Role;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private RequestRepositoryInterface $requestRepository;
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(RequestRepositoryInterface $requestRepository, EmployeeRepositoryInterface $employeeRepository)
    {
        $this->requestRepository = $requestRepository;
        $this->employeeRepository = $employeeRepository;
    }

    public function index()
    {
        $employee = $this->employeeRepository->getEmployee(auth()->id());
        $notLeader = $employee->role === Role::USER;

        if ($notLeader) {
            $requests = $this->requestRepository->getRequestsForEmployee(auth()->id());
        } else {
            $requests = $this->requestRepository->getPendingTeamRequestsForTeamLeader($employee->team_id);
        }

        $approvedRequests = [];
        $pendingRequests = [];
        $declinedRequests = [];

        if ($notLeader) {
            foreach ($requests as $request) {
                if ($request->status === 'Pending') {
                    $pendingRequests[] = $request;
                }
                if ($request->status === 'Approved') {
                    $declinedRequests[] = $request;
                }
                if ($request->status === 'Declined') {
                    $approvedRequests[] = $request;
                }
            }
        }

        return view('dashboard', [
            'requests' => $requests,
            'approvedRequests' => $approvedRequests,
            'pendingRequests' => $pendingRequests,
            'declinedRequests' => $declinedRequests,
            'notLeader' => $notLeader
        ]);
    }
}
