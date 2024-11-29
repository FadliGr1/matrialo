<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Test Email</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h2 style="color: #333;">Test Email</h2>
        <p>Hello,</p>
        <p>This is a test email to verify your mail configuration. If you're receiving this email, it means your mail settings are working correctly.</p>
        <p>Configuration details:</p>
        <ul>
            <li>Driver: {{ $settings['mail_driver'] }}</li>
            <li>From: support@matrialo.com</li>
        </ul>
        <p style="margin-top: 20px;">Best regards,<br>{{ $settings['app_name'] }}</p>
    </div>
</body>
</html>