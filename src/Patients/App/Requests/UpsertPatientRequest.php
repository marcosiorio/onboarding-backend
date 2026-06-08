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
        return [
            self::NAME  => ['required', 'string', 'min:4', 'max:100'],
            self::EMAIL => ['required', 'email', 'max:255'],
        ];
    }

    public function getName(): string
    {
        return $this->string(self::NAME)->toString();
    }

    public function getEmail(): string
    {
        return $this->string(self::EMAIL)->toString();
    }
}
