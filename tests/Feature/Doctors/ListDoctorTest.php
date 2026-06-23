<?php

declare(strict_types=1);

use Database\Factories\DoctorFactory;
use Lightit\Doctors\App\Resources\DoctorResource;
use function Pest\Laravel\getJson;

describe('doctors', function (): void {
    it('lists all doctors', function (): void {
        $doctors = DoctorFactory::new()
            ->createMany(3)
            ->sortByDesc('id');

        /** @var array{data: array} $expectedResponse */
        $expectedResponse = DoctorResource::collection($doctors)
            ->response()
            ->getData(true);

        getJson(url('/api/doctors'))
            ->assertSuccessful()
            ->assertJsonPath('data', $expectedResponse['data']);
    });

    it('returns an empty array', function (): void {
        getJson(url('/api/doctors'))
            ->assertSuccessful()
            ->assertJsonCount(0, 'data');
    });
});