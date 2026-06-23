<?php

declare(strict_types=1);

use Database\Factories\ClinicFactory;
use Lightit\Clinics\Domain\Models\Clinic;
use function Pest\Laravel\postJson;
use function Pest\Laravel\assertDatabaseCount;

describe('store clinic', function (): void {
    it('creates a new clinic', function (): void {
        $clinicData = ClinicFactory::new()->make()->toArray();

        $response = postJson(url('/api/clinics'), $clinicData);
        $response->assertCreated();
        assertDatabaseCount(Clinic::class, 1);
    });

    it('fails with empty clinic data', function (): void {
        $clinicData = [];
        $response =  postJson(url('/api/clinics'), $clinicData);
        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'address'], 'error.fields');
        assertDatabaseCount(Clinic::class, 0);
    });

    it('fails when name is shorter than 4 characters', function (): void {
        $clinicData = ClinicFactory::new()->name('fac')->make()->toArray();

        $response = postJson(url('/api/clinics'), $clinicData);
        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('name', 'error.fields');
    });

    it('fails when name is larger than 100 characters', function (): void {
        $clinicData = ClinicFactory::new()->name(fake()->password(101, 101))->make()->toArray();

        $response = postJson(url('/api/clinics'), $clinicData);
        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('name', 'error.fields');
    });
});
