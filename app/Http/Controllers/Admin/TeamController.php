<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\EmployeeRepositoryInterface;
use App\Contracts\RequestRepositoryInterface;
use App\Contracts\TeamRepositoryInterface;
use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
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
        $this->requestRepository = $requestRepository;
        $this->teamRepository = $teamRepository;

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = $this->teamRepository->getTeams();
        $paginated = Helper::paginate($teams);

        return view('admin.teams.index', ['teams' => $paginated]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        $validated = $request->validated();

        $this->teamRepository->createTeam($validated);

        return redirect()->route('admin.teams.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $team = $this->teamRepository->getTeam($id);
        $employees = $this->employeeRepository->getEmployeesByTeam($id);

        if (empty($team)) {
            throw new NotFoundHttpException();
        }

        $upcomingVacations = $this->requestRepository->getUpcomingVacationsForTeam($id);
        $inProgressVacations = $this->requestRepository->getInProgressVacationsForTeam($id);

        return view('admin.teams.show', ['t' => $team,
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
        $team = $this->teamRepository->getTeam($id);

        if (empty($team)) {
            throw new NotFoundHttpException();
        }

        $employees = $this->employeeRepository->getEmployeesByTeam($id);

        return view('admin.teams.edit', ['t' => $team, 'employees' => $employees]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, string $id)
    {
        $validated = $request->validated();

        $team = $this->teamRepository->getTeam($id);

        if (empty($team)) {
            throw new NotFoundHttpException();
        }

        $validated['old_team_leader_id'] = $team->tl_id;
        $validated['old_project_leader_id'] = $team->pl_id;

        $this->teamRepository->updateTeam($validated);
        $team = $this->teamRepository->getTeam($id);

        return redirect()->route('admin.teams.show', ['team' => $team->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->teamRepository->deleteTeam($id);

        return redirect()->route('admin.teams.index');
    }
}
