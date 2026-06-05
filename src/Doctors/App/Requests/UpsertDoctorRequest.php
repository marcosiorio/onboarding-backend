<?php

declare(strict_types=1);

namespace Lightit\Doctors\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpsertDoctorRequest extends FormRequest
{
    public const string NAME = 'name';

    public function rules(): array
    {
        return [
            self::NAME => ['required', 'string', 'min:4', 'max:100'],
        ];
    }

    public function getName(): string
    {
        $value = $this->input(self::NAME);

        return is_string($value) ? $value : '';
    }
}
