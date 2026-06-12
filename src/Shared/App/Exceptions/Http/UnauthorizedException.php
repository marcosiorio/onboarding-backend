<?php

declare(strict_types=1);

namespace Lightit\Shared\App\Exceptions\Http;

use Illuminate\Http\JsonResponse;

class UnauthorizedException extends HttpException
{
    /**
     * An HTTP status code.
     */
    #[\Override]
    protected int $status = JsonResponse::HTTP_UNAUTHORIZED;

    /**
     * An error code.
     */
    #[\Override]
    protected string $errorCode = 'unauthorized';
}
