<?php

declare(strict_types=1);

namespace Lightit\Clinics\Domain\Actions;

use Lightit\Clinics\Domain\Models\Clinic;

final readonly class UpdateClinicAction
{
    public function execute(Clinic $clinic, string|null $name, string|null $address): Clinic
    {
        if ($name !== null) {
            $clinic->name = $name;
        }

        if ($address !== null) {
            $clinic->address = $address;
        }

        $clinic->saveOrFail();

        return $clinic;
    }
}
