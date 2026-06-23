<?php

declare(strict_types=1);

namespace Tests\Unit\Patients;

use Database\Factories\PatientFactory;
use Illuminate\Support\Arr;
use Lightit\Patients\App\Resources\PatientResource;
use Tests\TestCase;

final class PatientResourceTest extends TestCase
{
    public function test_structure(): void
    {
        $expectedKeys = ['id', 'name', 'email'];

        $patient = PatientFactory::new()->createOne();
        /** @var array $patientResourceResponseData */
        $patientResourceResponseData = PatientResource::make($patient)->response()->getData(true);
        $patientResourceAttributes   = Arr::get($patientResourceResponseData, 'data');
        expect(array_keys($patientResourceAttributes))->toEqual($expectedKeys);
    }
}