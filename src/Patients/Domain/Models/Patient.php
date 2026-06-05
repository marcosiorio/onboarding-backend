<?php

declare(strict_types=1);

namespace Lightit\Patients\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lightit\Appointments\Domain\Models\Appointment;

/**
 * @property int                     $id
 * @property string                  $name
 * @property string                  $email
 * @property \Carbon\CarbonImmutable $created_at
 * @property \Carbon\CarbonImmutable $updated_at
 * @property string|null             $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Appointment> $appointment
 * @property-read int|null $appointment_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Patient extends Model
{
    use SoftDeletes;

    #[\Override]
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Lightit\Appointments\Domain\Models\Appointment, $this>
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
