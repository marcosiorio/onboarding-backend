<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Doctors\Domain\Models\Doctor;

final class UpdateAppointmentRequest extends FormRequest
{
    public const string DOCTOR_ID = 'doctor_id';

    public const string PATIENT_ID = 'patient_id';

    public const string CLINIC_ID = 'clinic_id';

    public const string START_DATE = 'start_date';

    public const string END_DATE = 'end_date';

    public function rules(): array
    {
        return [
            self::DOCTOR_ID => [
                'required',
                'integer',
                Rule::exists(Doctor::class, 'id'),
            ],
            self::PATIENT_ID => ['prohibited'],
            self::CLINIC_ID => ['prohibited'],
            self::START_DATE => ['required', 'date', Rule::date()->todayOrAfter()],
            self::END_DATE => ['required', Rule::date()->after(self::START_DATE)],
        ];
    }

    public function toDto(Appointment $appointment): AppointmentDto
    {
        return new AppointmentDto(
            doctor_id: $this->integer(self::DOCTOR_ID),
            patient_id: $appointment->patient_id,
            clinic_id: $appointment->clinic_id,
            start_date: $this->string(self::START_DATE)->toString(),
        );
    }
}
