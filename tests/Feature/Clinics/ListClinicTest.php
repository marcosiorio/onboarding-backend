<?php

declare(strict_types=1);


use Database\Factories\ClinicFactory;
use Lightit\Clinics\App\Resources\ClinicResource;
use function Pest\Laravel\getJson;

describe('clinics', function(): void {
    it('lists all clinics', function() {
       $clinics = ClinicFactory::new()
           ->createMany(5)
           ->loadCount('doctors')
           ->sortByDesc('id');

       /** @var array{data: array} $expectedResponse */
       $expectedResponse = ClinicResource::collection($clinics)
           ->response()
           ->getData(true);
       $response = getJson(url('/api/clinics'));

       $response
           ->assertSuccessful()
           ->assertJsonPath('data', $expectedResponse['data']);
    });

    it('return a empty array', function() {
        getJson(url('/api/clinics'))
            ->assertSuccessful()
            ->assertJsonCount(0, 'data');
    });
});
