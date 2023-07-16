<?php

namespace App\Http\Controllers;

use App\Contracts\EmployeeRepositoryInterface;
use App\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployeeController extends Controller
{
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
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
        $employee = $this->employeeRepository->getEmployee($id);
        $current = $this->employeeRepository->getEmployee(auth()->id());

        if (empty($employee)) {
            throw new NotFoundHttpException();
        }

        if ($employee->id != $current->id) {

            if ($current->team_id == $employee->team_id) {
                if (!in_array($current->role, [Role::PROJECT_LEADER, Role::TEAM_LEADER])) {
                    throw new AuthorizationException();
                }
            }
        }

        return view('employees.show', ['e' => $employee]);
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
