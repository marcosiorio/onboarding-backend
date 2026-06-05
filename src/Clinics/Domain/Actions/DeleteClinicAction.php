<?php

declare(strict_types=1);

namespace Lightit\Clinics\Domain\Actions;

use Lightit\Clinics\Domain\Models\Clinic;

final class DeleteClinicAction
{
    public function execute(Clinic $clinic): bool
    {
        return $clinic->deleteOrFail();
    }
}
