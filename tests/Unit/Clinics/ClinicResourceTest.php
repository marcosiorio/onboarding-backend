<?php

declare(strict_types=1);

namespace Tests\Unit\Clinics;

use Database\Factories\ClinicFactory;
use Illuminate\Support\Arr;
use Lightit\Clinics\App\Resources\ClinicResource;
use Tests\TestCase;

final class ClinicResourceTest extends TestCase
{
    public function test_structure(): void
    {
        $expectedKeys = ['id', 'name', 'address', 'total_doctors'];

        $clinic = ClinicFactory::new()->createOne()->loadCount('doctors');
        /** @var array $clinicResourceResponseData */
        $clinicResourceResponseData = ClinicResource::make($clinic)->response()->getData(true);
        $clinicResourceAttributes = Arr::array($clinicResourceResponseData, 'data');
        expect(array_keys($clinicResourceAttributes))->toEqual($expectedKeys);
    }
}
