<?php

declare(strict_types=1);

use Database\Factories\DoctorFactory;
use Lightit\Doctors\Domain\Models\Doctor;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\postJson;

describe('store doctor', function (): void {
    it('creates a new doctor', function (): void {
        $doctorData = DoctorFactory::new()->make()->toArray();

        postJson(url('/api/doctors'), $doctorData)
            ->assertCreated();

        assertDatabaseCount(Doctor::class, 1);
    });

    it('fails with empty doctor data', function (): void {
        postJson(url('/api/doctors'), [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name'], 'error.fields');

        assertDatabaseCount(Doctor::class, 0);
    });

    it('fails when name is shorter than 4 characters', function (): void {
        postJson(url('/api/doctors'), ['name' => 'abc'])
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('name', 'error.fields');
    });

    it('fails when name exceeds 100 characters', function (): void {
        postJson(url('/api/doctors'), ['name' => str_repeat('a', 101)])
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('name', 'error.fields');
    });
});