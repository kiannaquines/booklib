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

    private static $users = [
        ['name' => 'John Smith', 'email' => 'john.smith@example.com'],
        ['name' => 'Emily Johnson', 'email' => 'emily.johnson@example.com'],
        ['name' => 'Michael Williams', 'email' => 'michael.williams@example.com'],
        ['name' => 'Sarah Brown', 'email' => 'sarah.brown@example.com'],
        ['name' => 'David Jones', 'email' => 'david.jones@example.com'],
        ['name' => 'Jessica Garcia', 'email' => 'jessica.garcia@example.com'],
        ['name' => 'Daniel Martinez', 'email' => 'daniel.martinez@example.com'],
        ['name' => 'Ashley Rodriguez', 'email' => 'ashley.rodriguez@example.com'],
        ['name' => 'Matthew Wilson', 'email' => 'matthew.wilson@example.com'],
        ['name' => 'Amanda Taylor', 'email' => 'amanda.taylor@example.com'],
    ];
    
    private static $index = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = self::$users[self::$index % count(self::$users)];
        self::$index++;
        
        return [
            'name' => $user['name'],
            'email' => $user['email'],
            'email_verified_at' => now(),
            'number' => '09' . str_pad((string)(self::$index + 100000000), 9, '0', STR_PAD_LEFT),
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
