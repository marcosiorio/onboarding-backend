<?php

declare(strict_types=1);

namespace Lightit\Patients\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpsertPatientRequest extends FormRequest
{
    public const string NAME = 'name';

    public const string EMAIL = 'email';

    public const string PASSWORD = 'password';

    public function rules(): array
    {
        return [
            self::NAME  => ['required', 'string', 'min:4', 'max:100'],
            self::EMAIL => ['required', 'email', 'max:255'],
            self::PASSWORD => [
                'required',
                Password::default(),
                'confirmed',
            ],
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

    public function getPassword(): string
    {
        return $this->string(self::PASSWORD)->toString();
    }
}
