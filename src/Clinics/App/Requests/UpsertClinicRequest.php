<?php

declare(strict_types=1);

namespace Lightit\Clinics\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpsertClinicRequest extends FormRequest
{
    public const string NAME = 'name';
    public const string ADDRESS = 'address';

    public function rules(): array
    {
        $required = $this->isMethod('put') ? 'sometimes' : 'required';

        return [
            self::NAME    => [$required, 'string', 'min:4', 'max:100'],
            self::ADDRESS => [$required, 'string', 'max:255'],
        ];
    }

    public function getName(): ?string
    {
        return $this->input(self::NAME);
    }

    public function getAddress(): ?string
    {
        return $this->input(self::ADDRESS);
    }
}
