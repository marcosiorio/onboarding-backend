<?php

namespace Lightit\Appointments\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
use Lightit\Clinics\Domain\Models\Clinic;
use Lightit\Doctors\Domain\Models\Doctor;
use Lightit\Patients\Domain\Models\Patient;

final class UpsertAppointmentRequest extends FormRequest
{
    public const string DOCTOR_ID = 'doctor_id';

    public const string PATIENT_ID = 'patient_id';

    public const string CLINIC_ID = 'clinic_id';

    public const string START_DATE = 'start_date';

    public const string END_DATE = 'end_date';

    public function rules(): array
    {
        return [
            self::CLINIC_ID => ['required', 'integer', Rule::exists(Clinic::class, 'id')],
            self::DOCTOR_ID => [
                'required',
                'integer',
                Rule::exists(Doctor::class, 'id'),
            ],
            self::PATIENT_ID => ['required', 'integer',
                Rule::exists(Patient::class, 'id')],
            self::START_DATE => ['required', 'date', Rule::date()->todayOrAfter()],
            self::END_DATE => ['required', Rule::date()->after(self::START_DATE)],
        ];
    }

    public function toDto(): AppointmentDto
    {
        return new AppointmentDto(
            doctor_id: $this->input(self::DOCTOR_ID),
            patient_id: $this->input(self::PATIENT_ID),
            clinic_id: $this->input(self::CLINIC_ID),
            start_date: $this->string(self::START_DATE)->toString(),
            end_date: $this->string(self::END_DATE)->toString(),
        );
    }
}
