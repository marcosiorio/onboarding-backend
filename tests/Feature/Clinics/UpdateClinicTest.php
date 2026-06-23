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

    it('fails when name is missing', function (): void {
        $clinic = ClinicFactory::new()->createOne();

        $response = putJson("/api/clinics/{$clinic->id}", ['address' => 'Some Address 123']);
        $response->assertUnprocessable()
            ->assertJsonValidationErrorFor('name', 'error.fields');
    });

    it('fails when address is missing', function (): void {
        $clinic = ClinicFactory::new()->createOne();

        $response = putJson("/api/clinics/{$clinic->id}", ['name' => 'Valid Name']);
        $response->assertUnprocessable()
            ->assertJsonValidationErrorFor('address', 'error.fields');
    });

    it('fails when both name and address are missing', function (): void {
        $clinic = ClinicFactory::new()->createOne();

        $response = putJson("/api/clinics/{$clinic->id}", []);
        $response->assertUnprocessable()
            ->assertJsonValidationErrorFor('name', 'error.fields')
            ->assertJsonValidationErrorFor('address', 'error.fields');
    });
});
