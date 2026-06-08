<?php

declare(strict_types=1);

namespace Lightit\Patients\App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Lightit\Patients\Domain\Models\Patient;

/**
 * @mixin Patient
 */
class PatientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
        ];
    }
}
