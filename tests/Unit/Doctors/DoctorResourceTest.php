<?php

declare(strict_types=1);

namespace Tests\Unit\Doctors;

use Database\Factories\ClinicFactory;
use Database\Factories\DoctorFactory;
use Illuminate\Support\Arr;
use Lightit\Doctors\App\Resources\DoctorResource;
use Tests\TestCase;

final class DoctorResourceTest extends TestCase
{
    public function test_structure_without_clinics(): void
    {
        $expectedKeys = ['id', 'name'];

        $doctor = DoctorFactory::new()->createOne();
        /** @var array $doctorResourceResponseData */
        $doctorResourceResponseData = DoctorResource::make($doctor)->response()->getData(true);
        $doctorResourceAttributes = Arr::get($doctorResourceResponseData, 'data');
        expect(array_keys($doctorResourceAttributes))->toEqual($expectedKeys);
    }

    public function test_structure_with_clinics_loaded(): void
    {
        $expectedKeys = ['id', 'name', 'clinics'];

        $doctor = DoctorFactory::new()->createOne();
        ClinicFactory::new()->createOne()->doctors()->attach($doctor);
        $doctor->load('clinics');

        /** @var array $doctorResourceResponseData */
        $doctorResourceResponseData = DoctorResource::make($doctor)->response()->getData(true);
        $doctorResourceAttributes = Arr::get($doctorResourceResponseData, 'data');
        expect(array_keys($doctorResourceAttributes))->toEqual($expectedKeys);
    }
}
