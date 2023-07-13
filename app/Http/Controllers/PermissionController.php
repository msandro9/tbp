<?php

namespace App\Http\Controllers;

use App\Contracts\EmployeeRepositoryInterface;
use App\Contracts\RequestRepositoryInterface;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\RequestStatus;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PermissionController extends Controller
{
    private RequestRepositoryInterface $requestRepository;
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(RequestRepositoryInterface $requestRepository, EmployeeRepositoryInterface $employeeRepository)
    {
        $this->requestRepository = $requestRepository;
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $request, string $permission)
    {
        $requestId = $request;

        $request = $this->requestRepository->getRequest($request);
        $permission = $this->requestRepository->getPermission($permission);

        if (empty($permission) || empty($request) || $permission->request_id != $request->id) {
            throw new NotFoundHttpException();
        }

        $employee = $this->employeeRepository->getEmployee(auth()->id());

        if ($request->team_id != $employee->team_id) {
            throw new AuthorizationException();
        }

        if ($permission->type != $employee->role) {
            throw new AuthorizationException();
        }

        return view('permissions.edit', [
            'request' => $request,
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $r, string $request, string $permission)
    {
        $validated = $r->validated();
        unset($validated['request_id']);
        $validated['accepted'] = filter_var($validated['accepted'], FILTER_VALIDATE_BOOLEAN);

        $requestId = $request;
        $permissionId = $permission;

        $request = $this->requestRepository->getRequest($request);

        if ($request->status != RequestStatus::PENDING) {
            return redirect()->route('employee.requests.show', [
                'request' => $request->id,
            ]);
        }

        $permission = $this->requestRepository->getPermission($permission);

        if (empty($permission) || empty($request) || $permission->request_id != $request->id) {
            throw new NotFoundHttpException();
        }

        $employee = $this->employeeRepository->getEmployee(auth()->id());

        $validated['employee_id'] = $employee->id;
        $validated['id'] = $permission->id;

        if ($request->team_id != $employee->team_id) {
            throw new AuthorizationException();
        }

        if ($permission->type != $employee->role) {
            throw new AuthorizationException();
        }

        $this->requestRepository->updatePermission($permissionId, $validated);

        return redirect()->route('employee.requests.show', [
           'request' => $request->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
