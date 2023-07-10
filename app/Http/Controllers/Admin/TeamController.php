<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\EmployeeRepositoryInterface;
use App\Contracts\TeamRepositoryInterface;
use App\Helper\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TeamController extends Controller
{
    private EmployeeRepositoryInterface $employeeRepository;

    private TeamRepositoryInterface $teamRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository, TeamRepositoryInterface $teamRepository)
    {
        $this->employeeRepository = $employeeRepository;
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

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $team = $this->teamRepository->getTeam($id);
        $employees = $this->employeeRepository->getEmployeesByTeam($id);
        $employeesPaginated = Helper::paginate($employees);

        if (empty($team)) {
            throw new NotFoundHttpException();
        }

        return view('admin.teams.show', ['t' => $team, 'employees' => $employeesPaginated]);
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
