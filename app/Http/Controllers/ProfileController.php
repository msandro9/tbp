<?php

namespace App\Http\Controllers;

use App\Contracts\EmployeeRepositoryInterface;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $employee = $this->employeeRepository->getEmployee(\auth()->id());
        $data = explode(',', $employee->address);

        $employee->street = trim($data[0]);
        $employee->number = trim($data[1]);
        $employee->postal_code = trim($data[2]);
        $employee->city = trim($data[3]);
        $employee->country = trim($data[4]);

        return view('profile-edit', [
            'user' => $employee,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['id'] = \auth()->id();

        $this->employeeRepository->updateProfile($validated);

        return Redirect::route('employee.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
