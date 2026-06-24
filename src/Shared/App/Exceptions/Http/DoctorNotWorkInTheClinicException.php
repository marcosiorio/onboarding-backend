<?php

declare(strict_types=1);

namespace Lightit\Shared\App\Exceptions\Http;

use Illuminate\Http\JsonResponse;

class DoctorNotWorkInTheClinicException extends HttpException
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
    protected string $errorCode = 'doctor_not_work_in_the_clinic';

}
