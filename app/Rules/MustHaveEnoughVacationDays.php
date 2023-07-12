<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MustHaveEnoughVacationDays implements \Illuminate\Contracts\Validation\Rule
{
    public function __construct($start_date)
    {
        $this->start_date = $start_date;
    }


    public function passes($attribute, $value)
    {
        $id = auth()->user()->id;

        $days = DB::select("
            SELECT vacation_days FROM employees WHERE id = :id LIMIT 1
        ", ['id' => $id]);

        $days = $days[0]->vacation_days;
        $end_date = Carbon::parse($value);
        $start_date = Carbon::parse($this->start_date);
        $diff = $end_date->diffInWeekdays($start_date);

        if ($diff > $days) {
            return false;
        }

        return true;

    }

    public function message()
    {
        return "You don't have enough vacation days left.";
    }
}
