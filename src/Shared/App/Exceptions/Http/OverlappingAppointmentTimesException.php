<?php

declare(strict_types=1);

namespace Lightit\Shared\App\Exceptions\Http;

use Illuminate\Http\JsonResponse;

class OverlappingAppointmentTimesException extends HttpException
{
    /**
     * An HTTP status code.
     */
    #[\Override]
    protected int $status = JsonResponse::HTTP_CONFLICT;

    /**
     * The error code.
     */
    #[\Override]
    protected string $errorCode = 'overlapping_appointment_times';
}
