<?php

declare(strict_types=1);

use Database\Factories\AppointmentFactory;
use Database\Factories\PatientFactory;
use Lightit\Appointments\App\Resources\AppointmentResource;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

describe('get appointment', function (): void {
    beforeEach(function (): void {
        actingAs(PatientFactory::new()->createOne(), 'api');
    });

    it('returns an appointment', function (): void {
        $appointment = AppointmentFactory::new()->createOne()->refresh();

        /** @var array{data: array} $expected */
        $expected = AppointmentResource::make($appointment)->response()->getData(true);

        getJson("/api/appointments/{$appointment->id}")
            ->assertOk()
            ->assertJsonPath('data', $expected['data']);
    });

    it('returns 404 when appointment does not exist', function (): void {
        getJson('/api/appointments/999')
            ->assertNotFound();
    });
});

describe('get appointment (unauthenticated)', function (): void {
    it('returns 401', function (): void {
        $appointment = AppointmentFactory::new()->createOne();

        getJson("/api/appointments/{$appointment->id}")
            ->assertUnauthorized();
    });
});
