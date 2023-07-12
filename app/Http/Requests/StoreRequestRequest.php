<?php

namespace App\Http\Requests;

use App\Rules\MustHaveEnoughVacationDays;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'start_date' => ['required', 'date', 'date_format:Y-m-d', 'after:today'],
            'end_date' => ['required', 'date', 'date_format:Y-m-d', 'after:start_date', new MustHaveEnoughVacationDays($this->start_date)]
        ];

    }
}
