<?php

declare(strict_types=1);

namespace Lightit\Doctors\Domain\Actions;

use Lightit\Doctors\Domain\Models\Doctor;

final class DeleteDoctorAction
{
    public function execute(Doctor $doctor): bool|null
    {
        return $doctor->deleteOrFail();
    }
}
