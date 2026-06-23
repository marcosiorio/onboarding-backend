<?php

declare(strict_types=1);

use Database\Factories\PatientFactory;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\deleteJson;

describe('delete patient', function (): void {
    it('deletes successfully', function (): void {
        $patient = PatientFactory::new()->createOne();

        deleteJson(url("/api/patients/{$patient->id}"))
            ->assertNoContent();

        assertSoftDeleted($patient);
    });

    it('fails to delete non-existing patient', function (): void {
        deleteJson(url('/api/patients/1'))
            ->assertNotFound();
    });
});
