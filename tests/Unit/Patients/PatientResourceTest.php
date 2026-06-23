<?php

declare(strict_types=1);

use Database\Factories\PatientFactory;
use Illuminate\Support\Arr;
use Lightit\Patients\App\Resources\PatientResource;

it('has the correct structure', function (): void {
    $expectedKeys = ['id', 'name', 'email'];

    $patient = PatientFactory::new()->createOne();
    /** @var array $patientResourceResponseData */
    $patientResourceResponseData = PatientResource::make($patient)->response()->getData(true);
    /** @var array<string, mixed> $patientResourceAttributes */
    $patientResourceAttributes = Arr::get($patientResourceResponseData, 'data');
    expect(array_keys($patientResourceAttributes))->toEqual($expectedKeys);
});
