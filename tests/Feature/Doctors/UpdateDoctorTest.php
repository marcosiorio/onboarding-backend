<?php

declare(strict_types=1);

use Database\Factories\DoctorFactory;
use function Pest\Laravel\putJson;

describe('update doctor info', function (): void {
    it('successfully updates doctor info', function (): void {
        $doctor = DoctorFactory::new()->createOne();

        putJson("/api/doctors/{$doctor->id}", ['name' => 'Dr. House'])
            ->assertOk()
            ->assertJsonPath('data.name', 'Dr. House');
    });

    it('fails when name is missing', function (): void {
        $doctor = DoctorFactory::new()->createOne();

        putJson("/api/doctors/{$doctor->id}", [])
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('name', 'error.fields');
    });

    it('fails when name is shorter than 4 characters', function (): void {
        $doctor = DoctorFactory::new()->createOne();

        putJson("/api/doctors/{$doctor->id}", ['name' => 'abc'])
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('name', 'error.fields');
    });

    it('fails when name exceeds 100 characters', function (): void {
        $doctor = DoctorFactory::new()->createOne();

        putJson("/api/doctors/{$doctor->id}", ['name' => str_repeat('a', 101)])
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('name', 'error.fields');
    });
});
