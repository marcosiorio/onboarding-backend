<?php

namespace Lightit\Doctors\Domain\DataTransferObjects;

readonly class DoctorDto
{
    public function __construct(public string $name)
    {}
}
