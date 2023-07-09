<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $street = $this->faker->streetName;
        $street = str_replace("'", "", $street);
        $number = $this->faker->randomNumber();
        $postalCode = $this->faker->postcode;
        $city = $this->faker->randomElement(['Varazdin', 'Zagreb', 'Split']);
        $country = 'Croatia';

        $fullPath = Storage::path('avatar.png');

        $addressValue = DB::raw("ROW('$street', '$number', '$postalCode', '$city', '$country')");
        $pictureValue = DB::raw("lo_import('$fullPath')");

        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'password' => Hash::make(env('TEST_PASSWORD')),
            'role' => Role::USER,
            'address' => $addressValue,
            'picture' => $pictureValue,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
