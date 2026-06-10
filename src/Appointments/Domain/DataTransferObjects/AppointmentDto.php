<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\DataTransferObjects;

readonly class AppointmentDto
{
    public function __construct(
        public int $doctor_id,
        public int|null $patient_id = null,
        public int|null $clinic_id = null,
        public string $start_date,
    ) {
    }
}
