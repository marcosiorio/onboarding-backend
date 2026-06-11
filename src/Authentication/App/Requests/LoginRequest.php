<?php

declare(strict_types=1);

namespace Lightit\Authentication\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Email;
use Illuminate\Validation\Rules\Password;
use Lightit\Authentication\Domain\DataTransferObjects\CredentialsDto;

class LoginRequest extends FormRequest
{
    public const string EMAIL = 'email';

    public const string PASSWORD = 'password';

    public function rules(): array
    {
        return [
            self::EMAIL => ['required', Email::default()],
            self::PASSWORD => [
                'required',
                Password::default(),
            ],
        ];
    }

    public function toDto(): CredentialsDto
    {
        return new CredentialsDto(
            email: $this->string(self::EMAIL)->toString(),
            password: $this->string(self::PASSWORD)->toString(),
        );
    }
}
