<?php

namespace Database\Seeders;

use App\Models\Request;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $users = User::query()->where('role', Role::USER)->get();

        foreach ($users as $user) {
            $start_date = Carbon::now()->addDays($faker->numberBetween(7, 10));
            $end_date = Carbon::now()->addDays($faker->numberBetween(20, 27));
            $duration = $end_date->diffInWeekdays($start_date);

            Request::factory()->create(
                [
                    'employee_id' => $user->id,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'duration' => $duration
                ]
            );
        }
    }
}
