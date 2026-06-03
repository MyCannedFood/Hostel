<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: 'Segoe UI', sans-serif; background: #f5f2eb; margin: 0; padding: 24px; }
  .card { background: #fff; border-radius: 8px; max-width: 560px; margin: 0 auto; overflow: hidden; }
  .header { background: #1a3d0a; color: #fff; padding: 24px 28px; }
  .header h1 { margin: 0; font-size: 20px; }
  .body { padding: 28px; }
  .field { margin-bottom: 18px; }
  .label { font-size: 11px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: #7a857f; margin-bottom: 4px; }
  .value { font-size: 15px; color: #1a3d0a; }
  .message-box { background: #f5f2eb; border-left: 4px solid #d9864a; border-radius: 4px; padding: 14px 16px; margin-top: 20px; }
  .footer { font-size: 12px; color: #aaa; padding: 0 28px 20px; }
</style>
</head>
<body>
  <div class="card">
    <div class="header">
      <h1>New Contact Message — AlaSare</h1>
    </div>
    <div class="body">
      <div class="field">
        <div class="label">Name</div>
        <div class="value">{{ $message->name }}</div>
      </div>
      <div class="field">
        <div class="label">Email</div>
        <div class="value"><a href="mailto:{{ $message->email }}" style="color:#2d6a1e">{{ $message->email }}</a></div>
      </div>
      @if($message->phone)
      <div class="field">
        <div class="label">Phone</div>
        <div class="value">{{ $message->country_code }} {{ $message->phone }}</div>
      </div>
      @endif
      <div class="message-box">
        <div class="label" style="margin-bottom:8px">Message</div>
        <div class="value" style="white-space:pre-line">{{ $message->message }}</div>
      </div>
    </div>
    <div class="footer">
      Received on {{ $message->created_at->format('d M Y, H:i') }} WIB &nbsp;·&nbsp; AlaSare Hostel
    </div>
  </div>
</body>
</html>