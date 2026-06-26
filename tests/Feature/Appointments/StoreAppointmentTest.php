<?php

declare(strict_types=1);

use Database\Factories\AppointmentFactory;
use Database\Factories\ClinicFactory;
use Database\Factories\PatientFactory;
use Illuminate\Support\Facades\Notification;
use Lightit\Appointments\App\Notifications\AppointmentNotification;
use Lightit\Appointments\Domain\Models\Appointment;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\postJson;

describe('store appointments', function (): void {
    beforeEach(function (): void {
        $authUser = PatientFactory::new()->createOne();
        actingAs($authUser, 'api');
    });
    it('successfully store an appointment', function (): void {
        Notification::fake();
        $appt = AppointmentFactory::new()->make()->toArray();

        postJson(url('/api/appointments'), $appt)
            ->assertCreated();
        assertDatabaseCount('appointments', 1);

        $appointment = Appointment::with('patient')->firstOrFail();
        $appointment->patient->notify(new AppointmentNotification($appointment));

        Notification::assertSentTo($appointment->patient, AppointmentNotification::class);
    });

    it('fails with empty data', function (): void {
        $appt = [];

        postJson(url('/api/appointments'), $appt)->assertUnprocessable();
    });

    it('fails with doctor overlapping times', function (): void {
        $existingAppt = AppointmentFactory::new()->createOne();
        $newAppt = AppointmentFactory::new()->make([
            'doctor_id'  => $existingAppt->doctor_id,
            'clinic_id'  => $existingAppt->clinic_id,
            'start_date' => $existingAppt->start_date,
        ])->toArray();

        postJson(url('/api/appointments'), $newAppt)
            ->assertConflict()
            ->assertJsonPath('error.code', 'overlapping_appointment_times')
            ->assertJsonPath('error.message', 'Doctor is not available in this time, choose another one');
    });

    it('fails when overlapping time for patient', function (): void {
        $existingAppt = AppointmentFactory::new()->createOne();
        $newAppt = AppointmentFactory::new()->make([
            'patient_id'  => $existingAppt->patient_id,
            'start_date' => $existingAppt->start_date,
        ])->toArray();

        postJson(url('/api/appointments'), $newAppt)
            ->assertConflict()
            ->assertJsonPath('error.code', 'overlapping_appointment_times')
            ->assertJsonPath('error.message', 'You have an overlapping appointment in this time, choose another one.');
    });

    it('fails when doctor doenst work in that clinic', function (): void {
        $appt = AppointmentFactory::new()->make()->toArray();
        $appt['clinic_id'] = ClinicFactory::new()->createOne()->id;

        postJson(url('/api/appointments'), $appt)
            ->assertConflict()
            ->assertJsonPath('error.code', 'doctor_not_work_in_the_clinic')
            ->assertJsonPath('error.message', 'Selected doctor doesn\'t work at the selected clinic');
    });
});
