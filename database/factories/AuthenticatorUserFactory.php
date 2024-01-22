<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Position>
 */
class AuthenticatorUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'abzagency',
            'password' => Hash::make(env('AUTHENTICATOR_USER_PASSWORD','qwerty')),
        ];
    }
}
