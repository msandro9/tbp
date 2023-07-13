<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $details = [
            'first_name' => 'Administrator',
            'last_name' => 'Administrator',
            'email' => 'admin@example.com',
            'email_verified_at' => Carbon::now(),
            'remember_token' => Str::random(10),
            'password' => Hash::make(env('TEST_PASSWORD')),
            'role' => Role::ADMINISTRATOR
        ];

        $user = new User();
        $user->fill($details);
        $user->save();
    }
}
