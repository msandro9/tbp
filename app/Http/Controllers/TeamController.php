<?php

namespace App\Http\Controllers;

use App\Contracts\EmployeeRepositoryInterface;
use App\Contracts\RequestRepositoryInterface;
use App\Contracts\TeamRepositoryInterface;
use App\Helper\Helper;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TeamController extends Controller
{
    private EmployeeRepositoryInterface $employeeRepository;

    private TeamRepositoryInterface $teamRepository;

    private RequestRepositoryInterface $requestRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository, TeamRepositoryInterface $teamRepository, RequestRepositoryInterface $requestRepository)
    {
        $this->employeeRepository = $employeeRepository;
        $this->teamRepository = $teamRepository;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = $this->employeeRepository->getEmployee(auth()->id());

        if ($employee->team_id != $id) {
            throw new AuthorizationException();
        }

        $team = $this->teamRepository->getTeam($id);
        $employees = $this->employeeRepository->getEmployeesByTeam($id);

        $upcomingVacations = $this->requestRepository->getUpcomingVacationsForTeam($id);
        $inProgressVacations = $this->requestRepository->getInProgressVacationsForTeam($id);

        if (empty($team)) {
            throw new NotFoundHttpException();
        }

        return view('teams.show', [
            't' => $team,
            'employees' => $employees,
            'inprogress' => $inProgressVacations,
            'upcoming' => $upcomingVacations
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
