<?php

namespace App\Http\Requests;

use App\Contracts\EmployeeRepositoryInterface;
use App\Contracts\RequestRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class UpdatePermissionRequest extends FormRequest
{
    public function __construct(private EmployeeRepositoryInterface $employeeRepository, private RequestRepositoryInterface $requestRepository)
    {

    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $accepted = $this->input('accepted');
            $id = $this->input('request_id');

            if ($accepted) {
                $request = $this->requestRepository->getRequest($id);
                $duration = $request->duration;

                $employee = $this->employeeRepository->getEmployee($request->employee_id);
                $vacationDays = $employee->vacation_days;

                if ($vacationDays < $duration) {
                    $validator->errors()->add('accepted', "Employee doesn't have enough vacation days left.");
                }
            }
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'accepted' => ['required', 'in:true,false'],
            'note' => ['nullable', 'string', 'max:255'],
            'request_id' => ['required', 'exists:requests,id']
        ];
    }
}
