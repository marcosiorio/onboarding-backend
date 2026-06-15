<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Appointment email</title>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
            .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
            .header { background-color: #4F46E5; padding: 32px; text-align: center; }
            .header h1 { color: #ffffff; margin: 0; font-size: 24px; }
            .body { padding: 32px; }
            .message { font-size: 16px; color: #374151; margin-bottom: 24px; }
            .card { background-color: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 8px; padding: 24px; margin-bottom: 24px; }
            .card-title { font-size: 14px; font-weight: bold; color: #6B7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px; }
            .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #E5E7EB; }
            .detail-row:last-child { border-bottom: none; }
            .detail-label { color: #6B7280; font-size: 14px; }
            .detail-value { color: #111827; font-size: 14px; font-weight: 500; }
            .footer { background-color: #F9FAFB; padding: 24px; text-align: center; font-size: 12px; color: #9CA3AF; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Appointment Confirmation</h1>
            </div>
            <div class="body">
                <p class="message">Hi {{ $patient->name }}, {{ $body }}</p>

                <div class="card">
                    <div class="card-title">Appointment Details</div>
                    <div class="detail-row">
                        <span class="detail-label">Doctor</span>
                        <span class="detail-value">{{ $appointment->doctor->name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Clinic</span>
                        <span class="detail-value">{{ $appointment->clinic->name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Date</span>
                        <span class="detail-value">{{ \Carbon\Carbon::parse($appointment->start_date)->format('F j, Y') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Time</span>
                        <span class="detail-value">
                            {{ \Carbon\Carbon::parse($appointment->start_date)->format('g:i A') }} –
                            {{ \Carbon\Carbon::parse($appointment->end_date)->format('g:i A') }}
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Status</span>
                        <span class="detail-value">{{ ucfirst($appointment->status) }}</span>
                    </div>
                </div>
            </div>
            <div class="footer">
                <p>If you have any questions, please contact us.</p>
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
