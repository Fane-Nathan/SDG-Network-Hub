<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = fake()->randomElement(['organization', 'individual']);

        return [
            'name' => $role === 'organization' ? fake()->company() : fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'role' => $role,
            'organization_name' => $role === 'organization' ? fake()->company() : null,
            'organization_type' => $role === 'organization' ? fake()->randomElement(['NGO', 'Government', 'Social Enterprise']) : null,
            'website' => $role === 'organization' ? fake()->url() : null,
            'contact_phone' => fake()->phoneNumber(),
            'location_country' => fake()->country(),
            'location_city' => fake()->city(),
            'focus_areas' => fake()->randomElement(['SDG 1, SDG 4', 'SDG 8, SDG 10', 'SDG 17']),
            'skills' => $role === 'individual' ? fake()->randomElement(['Project Management, Facilitation', 'Monitoring & Evaluation', 'Community Outreach']) : null,
            'bio' => $role === 'individual' ? fake()->paragraph() : fake()->catchPhrase(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}