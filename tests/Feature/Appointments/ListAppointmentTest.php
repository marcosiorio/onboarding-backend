<?php

declare(strict_types=1);

use Database\Factories\AppointmentFactory;
use Database\Factories\PatientFactory;
use Lightit\Appointments\App\Resources\AppointmentResource;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

describe('list appointments', function (): void {
    beforeEach(function (): void {
        actingAs(PatientFactory::new()->createOne(), 'api');
    });

    it('lists all appointments', function (): void {
        $appointments = AppointmentFactory::new()->createMany(3);
        $appointments->each->refresh();
        $appointments = $appointments->sortByDesc('id');

        /** @var array{data: array} $expected */
        $expected = AppointmentResource::collection($appointments)->response()->getData(true);

        getJson(url('/api/appointments'))
            ->assertOk()
            ->assertJsonPath('data', $expected['data']);
    });

    it('returns an empty list', function (): void {
        getJson(url('/api/appointments'))
            ->assertOk()
            ->assertJsonCount(0, 'data');
    });
});

describe('list appointments (unauthenticated)', function (): void {
    it('returns 401', function (): void {
        getJson(url('/api/appointments'))
            ->assertUnauthorized();
    });
});
