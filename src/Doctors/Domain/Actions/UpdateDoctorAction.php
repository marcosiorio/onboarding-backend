<?php

namespace Lightit\Doctors\Domain\Actions;

use Lightit\Doctors\Domain\Models\Doctor;

final readonly class UpdateDoctorAction
{
    public function execute(Doctor $doctor, string $name): Doctor
    {
        $doctor->name = $name;
        $doctor->save();

        return $doctor;
    }
}
