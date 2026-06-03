<?php

namespace Lightit\Doctors\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lightit\Doctors\Domain\DataTransferObjects\DoctorDto;

class UpsertDoctorRequest extends FormRequest
{
    public const string NAME = 'name';

    public function rules(): array
    {
        return [
            self::NAME => ['required', 'string', 'min:4', 'max:100'],
        ];
    }

    public function toDto(): DoctorDto
    {
        return new DoctorDto(
            name: $this->string(self::NAME)->toString(),
        );
    }
}
