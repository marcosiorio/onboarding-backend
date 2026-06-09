<?php

namespace Lightit\Appointments\Domain\Enums;

enum AppointmentStatusEnum: string
{
    case CANCELLED = 'cancelled';
    case ACTIVE = 'active';
}
