<?php

namespace Lightit\Doctors\Domain\Actions;

use Lightit\Doctors\Domain\Models\Doctor;

final class DeleteDoctorAction
{
    public function execute(Doctor $doctor): bool
    {
        return $doctor->deleteOrFail();

    }
}
