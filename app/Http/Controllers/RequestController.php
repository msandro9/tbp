<?php

namespace App\Http\Controllers;

use App\Contracts\EmployeeRepositoryInterface;
use App\Contracts\RequestRepositoryInterface;
use App\Http\Requests\StoreRequestRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RequestController extends Controller
{
    private EmployeeRepositoryInterface $employeeRepository;
    private RequestRepositoryInterface $requestRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository, RequestRepositoryInterface $requestRepository)
    {
        $this->employeeRepository = $employeeRepository;
        $this->requestRepository = $requestRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employee = $this->employeeRepository->getEmployee(Auth::id());

        return view('requests.create', ['vacation_days' => $employee->vacation_days]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequestRequest $request)
    {
        $validated = $request->validated();

        $this->requestRepository->createRequest($validated);

        return redirect()->route('employee.dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userId = \auth()->id();
        $request = $this->requestRepository->getRequest($id);

        if (empty($request)) {
            throw new NotFoundHttpException();
        }

        $teamLeader = $this->employeeRepository->getTeamLeader($request->team_id);
        $projectLeader = $this->employeeRepository->getProjectLeader($request->team_id);

        $teamLeaderPermission = $this->requestRepository->getTeamLeaderPermission($request->id);
        $projectLeaderPermission = $this->requestRepository->getProjectLeaderPermission($request->id);

        $isCreator = false;
        $isTeamLeader = false;
        $isProjectLeader = false;

        if ($userId === $request->employee_id) {
            $isCreator = true;
        }

        if ($userId === $teamLeader?->id) {
            $isTeamLeader = true;
        }

        if ($userId === $projectLeader?->id) {
            $isProjectLeader = true;
        }

        if (!$isCreator && !$isTeamLeader && !$isProjectLeader) {
            throw new AuthorizationException();
        }

        return view('requests.show', [
            'request' => $request,
            'teamLeader' => $teamLeader,
            'projectLeader' => $projectLeader,
            'teamLeaderPermission' => $teamLeaderPermission,
            'projectLeaderPermission' => $projectLeaderPermission,
            'isTeamLeader' => $isTeamLeader,
            'isProjectLeader' => $isProjectLeader,
            'isCreator' => $isCreator,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
