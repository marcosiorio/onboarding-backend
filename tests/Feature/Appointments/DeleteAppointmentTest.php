<?php

declare(strict_types=1);

use Database\Factories\AppointmentFactory;
use Database\Factories\PatientFactory;
use Lightit\Appointments\Domain\Enums\AppointmentStatusEnum;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\deleteJson;

describe('Delete appointment endpoint', function(): void {
    beforeEach(function() {
        $authUser = PatientFactory::new()->createOne();
        actingAs($authUser, 'api');
    });

    it('should soft delete when cancellation time >= 48h', function(): void {
        $appt = AppointmentFactory::new()->startingInHours(48)->createOne();

        deleteJson("/api/appointments/$appt->id")
        ->assertNoContent();
        assertSoftDeleted($appt);
    });

    it('should set status cancelled when cancellation time < 48h', function(): void {
        $appt = AppointmentFactory::new()->startingInHours(24)->createOne();

        deleteJson("/api/appointments/{$appt->id}")
            ->assertNoContent();

        expect($appt->refresh()->status)->toBe(AppointmentStatusEnum::CANCELLED->value);

    });
});
