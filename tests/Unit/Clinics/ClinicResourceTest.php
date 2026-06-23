<?php

declare(strict_types=1);

use Database\Factories\ClinicFactory;
use Illuminate\Support\Arr;
use Lightit\Clinics\App\Resources\ClinicResource;

it('has the correct structure', function (): void {
    $expectedKeys = ['id', 'name', 'address', 'total_doctors'];

    $clinic = ClinicFactory::new()->createOne()->loadCount('doctors');
    /** @var array $clinicResourceResponseData */
    $clinicResourceResponseData = ClinicResource::make($clinic)->response()->getData(true);
    $clinicResourceAttributes   = Arr::get($clinicResourceResponseData, 'data');
    expect(array_keys($clinicResourceAttributes))->toEqual($expectedKeys);
});
