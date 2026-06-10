<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\DataTransferObjects;

use Illuminate\Database\Eloquent\SoftDeletes;

readonly class AppointmentDto
{
    use SoftDeletes;
    public function __construct(
        public int $doctor_id,
        public int $patient_id,
        public int $clinic_id,
        public string $start_date,
    ) {
    }
}
