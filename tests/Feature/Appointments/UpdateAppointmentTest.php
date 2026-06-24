<?php

declare(strict_types=1);

use Database\Factories\AppointmentFactory;
use Database\Factories\DoctorFactory;
use Database\Factories\PatientFactory;
use Lightit\Appointments\App\Resources\AppointmentResource;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\putJson;

describe('update appointment', function (): void {
    beforeEach(function (): void {
        actingAs(PatientFactory::new()->createOne(), 'api');
    });

    it('successfully updates an appointment', function (): void {
        $appointment = AppointmentFactory::new()->createOne();
        $newDoctor = DoctorFactory::new()->createOne();
        $newDoctor->clinics()->attach($appointment->clinic_id);

        $payload = [
            'doctor_id'  => $newDoctor->id,
            'start_date' => now()->addDays(14)->format('Y-m-d H:i:s'),
            'end_date'   => now()->addDays(14)->addMinutes(30)->format('Y-m-d H:i:s'),
        ];

        $response = putJson("/api/appointments/{$appointment->id}", $payload)
            ->assertOk();

        /** @var array{data: array} $expected */
        $expected = AppointmentResource::make($appointment->refresh())->response()->getData(true);

        $response->assertJsonPath('data', $expected['data']);
    });

    it('fails with missing required fields', function (): void {
        $appointment = AppointmentFactory::new()->createOne();

        putJson("/api/appointments/{$appointment->id}", [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['doctor_id', 'start_date', 'end_date'], 'error.fields');
    });

    it('fails when start date is in the past', function (): void {
        $appointment = AppointmentFactory::new()->createOne();

        putJson("/api/appointments/{$appointment->id}", [
            'doctor_id'  => $appointment->doctor_id,
            'start_date' => now()->subDay()->format('Y-m-d H:i:s'),
            'end_date'   => now()->addMinutes(30)->format('Y-m-d H:i:s'),
        ])->assertUnprocessable()
            ->assertJsonValidationErrorFor('start_date', 'error.fields');
    });

    it('fails when doctor does not work at the clinic', function (): void {
        $appointment = AppointmentFactory::new()->createOne();
        $doctorFromAnotherClinic = DoctorFactory::new()->createOne();

        putJson("/api/appointments/{$appointment->id}", [
            'doctor_id'  => $doctorFromAnotherClinic->id,
            'start_date' => now()->addDays(14)->format('Y-m-d H:i:s'),
            'end_date'   => now()->addDays(14)->addMinutes(30)->format('Y-m-d H:i:s'),
        ])->assertConflict()
            ->assertJsonPath('error.code', 'doctor_not_work_in_the_clinic')
            ->assertJsonPath('error.message', "Selected doctor doesn't work at the selected clinic");
    });

    it('fails with doctor overlapping times', function (): void {
        $existingAppt = AppointmentFactory::new()->createOne();
        $apptToUpdate = AppointmentFactory::new()->startingInHours(72)->createOne();
        $existingAppt->doctor->clinics()->syncWithoutDetaching([$apptToUpdate->clinic_id]);

        putJson("/api/appointments/{$apptToUpdate->id}", [
            'doctor_id'  => $existingAppt->doctor_id,
            'start_date' => $existingAppt->start_date,
            'end_date'   => $existingAppt->end_date,
        ])->assertConflict()
            ->assertJsonPath('error.code', 'overlapping_appointment_times')
            ->assertJsonPath('error.message', 'Doctor is not available in this time, choose another one');
    });

    it('returns 404 when appointment does not exist', function (): void {
        putJson('/api/appointments/999', [])
            ->assertNotFound();
    });
});

describe('update appointment (unauthenticated)', function (): void {
    it('returns 401', function (): void {
        $appointment = AppointmentFactory::new()->createOne();

        putJson("/api/appointments/{$appointment->id}", [])
            ->assertUnauthorized();
    });
});
