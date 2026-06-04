<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { text-align: center; border-bottom: 2px solid #1A3D0A; padding-bottom: 10px; margin-bottom: 20px; }
        .total-box { background: #F2F5EB; padding: 15px; border-radius: 8px; text-align: center; margin-top: 20px; }
        .total-box h2 { margin: 0; color: #D9864A; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #1A3D0A;">ALASARE HOSTEL</h1>
            <p>Booking Receipt & Confirmation</p>
        </div>

        <p>Hi, <strong>{{ $guest->first_name }} {{ $guest->last_name }}</strong>!</p>
        <p>Thank you for choosing AlaSare Hostel. We have successfully received your payment.</p>

        <h3>Reservation Details:</h3>
        <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <tr><th style="padding: 8px 0; border-bottom: 1px solid #eee;">Booking ID</th><td style="padding: 8px 0; border-bottom: 1px solid #eee;"><b>{{ $booking->booking_code }}</b></td></tr>
            <tr><th style="padding: 8px 0; border-bottom: 1px solid #eee;">Check-in</th><td style="padding: 8px 0; border-bottom: 1px solid #eee;">{{ $booking->check_in_date }} (14:00)</td></tr>
            <tr><th style="padding: 8px 0; border-bottom: 1px solid #eee;">Check-out</th><td style="padding: 8px 0; border-bottom: 1px solid #eee;">{{ $booking->check_out_date }} (12:00)</td></tr>
            <tr><th style="padding: 8px 0; border-bottom: 1px solid #eee;">Payment Method</th><td style="padding: 8px 0; border-bottom: 1px solid #eee; text-transform: uppercase;">{{ str_replace('_', ' ', $booking->payment_method) }}</td></tr>
        </table>

        <div class="total-box">
            <p style="margin: 0; font-size: 14px; text-transform: uppercase;">Total Paid</p>
            <h2>IDR {{ number_format($booking->total_price, 0, ',', '.') }}</h2>
        </div>

        <p style="margin-top: 30px; font-size: 12px; color: #777; text-align: center;">
            Please present this email at the reception desk during your check-in.<br>
            If you have any questions, feel free to reply to this email.
        </p>
    </div>
</body>
</html>