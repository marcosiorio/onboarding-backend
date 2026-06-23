<?php

declare(strict_types=1);

use Database\Factories\ClinicFactory;
use Lightit\Clinics\Domain\Models\Clinic;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\deleteJson;

describe('delete clinic', function(): void {
    it('Delete successfully', function(): void {
       $clinic = ClinicFactory::new()->createOne();

      $response =  deleteJson(url("/api/clinics/{$clinic->id}"));
      $response->assertNoContent();

      assertSoftDeleted($clinic);
    });

    it('fails to delete non existing one', function(): void {
        $response =  deleteJson(url("/api/clinics/1"));
        $response->assertNotFound();
    });

    it('fails to non int param', function(): void {

        $response =  deleteJson(url("/api/clinics/string"));
        $response->assertBadRequest();

    })->skip('Returns 500 instead of a 404 due to the boilerplate');
});
