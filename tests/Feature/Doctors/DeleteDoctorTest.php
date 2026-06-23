<?php

declare(strict_types=1);

use Database\Factories\DoctorFactory;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\deleteJson;

describe('delete doctor', function (): void {
    it('deletes successfully', function (): void {
        $doctor = DoctorFactory::new()->createOne();

        deleteJson(url("/api/doctors/{$doctor->id}"))
            ->assertNoContent();

        assertSoftDeleted($doctor);
    });

    it('fails to delete non-existing doctor', function (): void {
        deleteJson(url('/api/doctors/1'))
            ->assertNotFound();
    });
});