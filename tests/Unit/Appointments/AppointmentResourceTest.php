<?php

declare(strict_types=1);

use Database\Factories\AppointmentFactory;
use Illuminate\Support\Arr;
use Lightit\Appointments\App\Resources\AppointmentResource;

it('has the correct structure', function (): void {
    $expectedKeys = ['id', 'doctor_id', 'patient_id', 'clinic_id', 'start_date', 'end_date', 'status'];

    $appointment = AppointmentFactory::new()->createOne();
    /** @var array $appointmentResourceResponseData */
    $appointmentResourceResponseData = AppointmentResource::make($appointment)->response()->getData(true);
    /** @var array<string, mixed> $appointmentResourceAttributes */
    $appointmentResourceAttributes = Arr::get($appointmentResourceResponseData, 'data');
    expect(array_keys($appointmentResourceAttributes))->toEqual($expectedKeys);
});