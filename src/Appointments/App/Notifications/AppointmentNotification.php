<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Patients\Domain\Models\Patient;

class AppointmentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Appointment $appointment)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(Patient $notifiable): MailMessage
    {
        return new MailMessage()
            ->subject('Appointment Created!')
            ->view('email.appointment-notifications', [
                'appointment' => $this->appointment,
                'patient' => $this->appointment->patient,
                'body' => $this->getMessage(),
            ]);
    }

    public function getMessage(): string
    {
        return $message = 'Your appointment has been scheduled. See the details below.';
    }

    public function toArray(object $notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'clinic_id' => $this->appointment->clinic->id,
            'doctor_id' => $this->appointment->doctor->id,
            'patient_id' => $this->appointment->patient->id,
            'start_time' => $this->appointment->start_date,
            'end_time' => $this->appointment->end_date,
        ];
    }
}
