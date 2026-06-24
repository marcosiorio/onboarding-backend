<?php

declare(strict_types=1);

use Database\Factories\AppointmentFactory;
use Database\Factories\ClinicFactory;
use Database\Factories\DoctorFactory;
use Database\Factories\PatientFactory;
use Lightit\Appointments\App\Resources\AppointmentResource;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\postJson;

describe('store appointments', function () {
    beforeEach(function () {
        $authUser = PatientFactory::new()->createOne();
        actingAs($authUser, 'api');
    });
    it('successfully store an appointment', function () {
        $appt = AppointmentFactory::new()->make()->toArray();

      postJson(url('/api/appointments'), $appt)
          ->assertCreated();
      assertDatabaseCount('appointments', 1);
    });

    it('fails with empty data', function() {
        $appt = [];

        postJson(url('/api/appointments'), $appt)
            ->assertStatus(422);
    });

    it('fails with doctor overlapping times', function () {
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

    it('fails when overlapping time for patient', function () {
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

    it('fails when doctor doenst work in that clinic', function () {
        $appt = AppointmentFactory::new()->make();
        $appt['clinic_id'] = ClinicFactory::new()->createOne()->id;

        postJson(url('/api/appointments'), $appt->toArray())
            ->assertConflict()
            ->assertJsonPath('error.code', 'doctor_not_work_in_the_clinic')
            ->assertJsonPath('error.message', 'Selected doctor doesn\'t work at the selected clinic');
    });
});
