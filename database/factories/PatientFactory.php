<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Lightit\Patients\Domain\Models\Patient;

/**
 * @extends Factory<Patient>
 */
class PatientFactory extends Factory

{
    protected $model = Patient::class;
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('>e$pV4chNFcJoAB%X#{'),
            'remember_token' => Str::random(10),
        ];
    }
}
