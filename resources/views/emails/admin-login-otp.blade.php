<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Verification</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6fa; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #333333;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f6fa; padding: 40px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" style="max-width: 520px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05); overflow: hidden; border: 1px solid #e5e7eb;">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 32px 32px 20px 32px; text-align: center; background-color: #0067da;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 22px; font-weight: 700; letter-spacing: 0.5px;">
                                RACAi Discipleship
                            </h1>
                            <p style="margin: 6px 0 0 0; color: rgba(255, 255, 255, 0.85); font-size: 13px; text-transform: uppercase; letter-spacing: 1.5px;">
                                Administrative Portal
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 32px;">
                            <h2 style="margin: 0 0 12px 0; color: #111827; font-size: 18px; font-weight: 600;">
                                Admin Sign-In Verification
                            </h2>
                            <p style="margin: 0 0 24px 0; color: #4b5563; font-size: 14px; line-height: 1.6;">
                                You recently requested to sign in to the Admin Dashboard. Use the 6-digit verification code below to complete your login.
                            </p>

                            <!-- OTP Box -->
                            <div style="background-color: #f0f7ff; border: 1.5px dashed #0067da; border-radius: 10px; padding: 20px; text-align: center; margin: 0 0 24px 0;">
                                <span style="font-family: 'Courier New', Courier, monospace; font-size: 34px; font-weight: 700; letter-spacing: 8px; color: #0067da;">
                                    {{ $otp }}
                                </span>
                            </div>

                            <p style="margin: 0 0 16px 0; color: #6b7280; font-size: 13px; line-height: 1.5;">
                                This code is valid for <strong>10 minutes</strong>. If you did not initiate this request, please secure your account immediately or notify the administrator.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 20px 32px; background-color: #f9fafb; border-top: 1px solid #e5e7eb; text-align: center;">
                            <p style="margin: 0; color: #9ca3af; font-size: 12px;">
                                &copy; {{ date('Y') }} {{ config('app.name', 'RACAi Discipleship') }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
