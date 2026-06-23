<?php

declare(strict_types=1);

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Database\Factories\AppointmentFactory;
use Database\Factories\PatientFactory;
use Lightit\Appointments\Domain\Enums\AppointmentStatusEnum;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\deleteJson;

describe('Delete appointment endpoint', function (): void {
    beforeEach(function (): void {
        $authUser = PatientFactory::new()->createOne();
        actingAs($authUser, 'api');
    });

    it('should soft delete when cancellation time >= 48h', function (): void {
        $appt = AppointmentFactory::new()->startingInHours(49)->createOne();
        deleteJson("/api/appointments/$appt->id")
        ->assertNoContent();
        assertSoftDeleted($appt);
    });

    it('should set status cancelled when cancellation time < 48h', function (): void {
        $appt = AppointmentFactory::new()->startingInHours(24)->createOne();

        deleteJson("/api/appointments/{$appt->id}")
            ->assertNoContent();

        expect($appt->refresh()->status)->toBe(AppointmentStatusEnum::CANCELLED);
    });

    it('returns 404 when appointment does not exist', function (): void {
        deleteJson('/api/appointments/999')
            ->assertNotFound();
    });
});

describe('Delete appointment endpoint (unauthenticated)', function (): void {
    it('returns 401 when unauthenticated', function (): void {
        $appt = AppointmentFactory::new()->startingInHours(49)->createOne();

        deleteJson("/api/appointments/{$appt->id}")
            ->assertUnauthorized();
    });
});
