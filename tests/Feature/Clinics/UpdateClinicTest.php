<?php

declare(strict_types=1);

use Database\Factories\ClinicFactory;
use Lightit\Clinics\Domain\Models\Clinic;
use function Pest\Laravel\putJson;

describe('update clinic info', function (): void {
    it('successfully updates clinic info', function (): void {
        $clinic = ClinicFactory::new()->createOne();
        $newClinicInfo = new Clinic();

        $newClinicInfo->id = $clinic->id;
        $newClinicInfo->name = 'Favaloro';
        $newClinicInfo->address = $clinic->address;

        $response = putJson("/api/clinics/{$clinic->id}", $newClinicInfo->toArray());
        $response->assertOk()
            ->assertJsonPath('data.name', 'Favaloro');
    });

    it('fails when both name and address are missing', function (): void {
        $clinic = ClinicFactory::new()->createOne();

        $response = putJson("/api/clinics/{$clinic->id}", []);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'address'], 'error.fields');
    });
});
