<?php

declare(strict_types=1);

namespace Lightit\Doctors\Domain\Actions;

use Lightit\Doctors\Domain\Models\Doctor;

final readonly class UpsertDoctorAction
{
    public function execute(string $name, Doctor|null $doctor = null): Doctor
    {
        $newDoctor = $doctor ?? new Doctor();

        $newDoctor->name = $name;

        $newDoctor->saveOrFail();

        return $newDoctor;
    }
}
