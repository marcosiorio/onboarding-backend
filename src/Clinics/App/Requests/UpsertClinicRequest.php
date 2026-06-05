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
        $value = $this->input(self::NAME);
        return is_string($value) ? $value : null;
    }

    public function getAddress(): ?string
    {
        $value = $this->input(self::ADDRESS);
        return is_string($value) ? $value : null;
    }
}
