<?php

declare(strict_types=1);

use Database\Factories\PatientFactory;
use Lightit\Patients\App\Resources\PatientResource;
use function Pest\Laravel\getJson;

describe('patients', function (): void {
    it('lists all patients', function (): void {
        $patients = PatientFactory::new()
            ->createMany(3)
            ->sortByDesc('id');

        /** @var array{data: array} $expectedResponse */
        $expectedResponse = PatientResource::collection($patients)
            ->response()
            ->getData(true);

        getJson(url('/api/patients'))
            ->assertSuccessful()
            ->assertJsonPath('data', $expectedResponse['data']);
    });

    it('returns an empty array', function (): void {
        getJson(url('/api/patients'))
            ->assertSuccessful()
            ->assertJsonCount(0, 'data');
    });
});