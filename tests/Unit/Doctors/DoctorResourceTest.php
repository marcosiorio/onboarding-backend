<?php

declare(strict_types=1);

use Database\Factories\ClinicFactory;
use Database\Factories\DoctorFactory;
use Illuminate\Support\Arr;
use Lightit\Doctors\App\Resources\DoctorResource;

it('has the correct structure without clinics', function (): void {
    $expectedKeys = ['id', 'name'];

    $doctor = DoctorFactory::new()->createOne();
    /** @var array $doctorResourceResponseData */
    $doctorResourceResponseData = DoctorResource::make($doctor)->response()->getData(true);
    $doctorResourceAttributes   = Arr::get($doctorResourceResponseData, 'data');
    expect(array_keys($doctorResourceAttributes))->toEqual($expectedKeys);
});

it('has the correct structure with clinics loaded', function (): void {
    $expectedKeys = ['id', 'name', 'clinics'];

    $doctor = DoctorFactory::new()->createOne();
    ClinicFactory::new()->createOne()->doctors()->attach($doctor);
    $doctor->load('clinics');

    /** @var array $doctorResourceResponseData */
    $doctorResourceResponseData = DoctorResource::make($doctor)->response()->getData(true);
    $doctorResourceAttributes   = Arr::get($doctorResourceResponseData, 'data');
    expect(array_keys($doctorResourceAttributes))->toEqual($expectedKeys);
});