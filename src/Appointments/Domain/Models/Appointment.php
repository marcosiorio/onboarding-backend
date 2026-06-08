<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lightit\Clinics\Domain\Models\Clinic;
use Lightit\Doctors\Domain\Models\Doctor;
use Lightit\Patients\Domain\Models\Patient;

/**
<<<<<<< feature/CU-86e1qjjaj/create-patient-and-clinics-CRUD-endpoints
 * @property int                          $id
 * @property int                          $doctor_id
 * @property int                          $patient_id
 * @property int                          $clinic_id
 * @property string                       $start_date
 * @property string                       $end_date
 * @property \Carbon\CarbonImmutable      $created_at
 * @property \Carbon\CarbonImmutable      $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read Clinic|null $clinic
 * @property-read Doctor|null $doctor
 * @property-read Patient|null $patient
=======
 * @property int                     $id
 * @property int                     $doctor_id
 * @property int                     $patient_id
 * @property int                     $clinic_id
 * @property string                  $start_date
 * @property string                  $end_date
 * @property \Carbon\CarbonImmutable $created_at
 * @property \Carbon\CarbonImmutable $updated_at
 * @property string|null             $deleted_at
 * @property-read Clinic|null $clinics
 * @property-read Doctor|null $doctors
 * @property-read Patient|null $patients
>>>>>>> develop
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereClinicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Appointment extends Model
{
    use SoftDeletes;

    #[\Override]
    protected $guarded = ['id'];

    public function patients(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function clinics(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function doctors(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
