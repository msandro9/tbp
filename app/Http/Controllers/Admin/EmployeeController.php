<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\EmployeeRepositoryInterface;
use App\Contracts\TeamRepositoryInterface;
use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployeeController extends Controller
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
        $employees = $this->employeeRepository->getEmployees();
        $paginated = Helper::paginate($employees);

        return view('admin.employees.index', ['employees' => $paginated]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $validated = $request->validated();
        $validated['role'] = Role::USER;
        $validated['password'] = Hash::make(env('TEST_PASSWORD'));

        $this->employeeRepository->createEmployee($validated);

        return redirect()->route('admin.employees.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = $this->employeeRepository->getEmployee($id);

        if (empty($employee)) {
            throw new NotFoundHttpException();
        }

        return view('admin.employees.show', ['e' => $employee]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = $this->employeeRepository->getEmployee($id);

        if (empty($employee)) {
            throw new NotFoundHttpException();
        }

        $teams = $this->teamRepository->getTeams();
        return view('admin.employees.edit', ['e' => $employee, 'teams' => $teams]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, string $id)
    {
        $validated = $request->validated();

        $this->employeeRepository->updateEmployee($id, $validated);

        $employee = $this->employeeRepository->getEmployee($id);

        if (empty($employee)) {
            throw new NotFoundHttpException();
        }

        $employee = $this->employeeRepository->getEmployee($id);

        return redirect()->route('admin.employees.show', ['employee' => $employee->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->employeeRepository->deleteEmployee($id);

        return redirect()->route('admin.employees.index');
    }
}
