<?php

declare(strict_types=1);

namespace Lightit\Clinics\Domain\Actions;

use Lightit\Clinics\Domain\Models\Clinic;

final readonly class UpdateClinicAction
{
    public function execute(Clinic $clinic, string $name, string $address): Clinic
    {
        $clinic->name = $name;
        $clinic->address = $address;

        $clinic->saveOrFail();

        return $clinic;
    }
}
