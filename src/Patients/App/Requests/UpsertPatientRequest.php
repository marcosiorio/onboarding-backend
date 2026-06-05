<?php

declare(strict_types=1);

namespace Lightit\Patients\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpsertPatientRequest extends FormRequest
{
    public const string NAME = 'name';

    public const string EMAIL = 'email';

    public function rules(): array
    {
        $required = $this->isMethod('put') ? 'sometimes' : 'required';

        return [
            self::NAME  => [$required, 'string', 'min:4', 'max:100'],
            self::EMAIL => [$required, 'email', 'max:255'],
        ];
    }

    public function getName(): ?string
    {
        $value = $this->input(self::NAME);
        return is_string($value) ? $value : null;
    }

    public function getEmail(): ?string
    {
        $value = $this->input(self::EMAIL);
        return is_string($value) ? $value : null;
    }
}
