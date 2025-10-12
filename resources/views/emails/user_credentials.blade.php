<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Created</title>
</head>
<body style="font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 0; color: #333;">
    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="margin: 0; padding: 30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.05);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #2563eb; color: #fff; text-align: center; padding: 20px 10px;">
                            <h1 style="margin: 0; font-size: 22px;">Keysoft ERP System</h1>
                            <p style="margin: 5px 0 0; font-size: 14px;">Your Account Has Been Created</p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <h2 style="color: #111827; font-size: 20px;">Hello {{ $user->name }},</h2>
                            <p style="font-size: 15px; line-height: 1.6; color: #374151;">
                                Your account has been created successfully. Below are your login details:
                            </p>

                            <table cellpadding="6" cellspacing="0" style="width: 100%; border: 1px solid #e5e7eb; border-radius: 6px; margin-top: 15px;">
                                <tr style="background: #f9fafb;">
                                    <td style="width: 150px; font-weight: 600; color: #111827;">Email:</td>
                                    <td style="color: #374151;">{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 150px; font-weight: 600; color: #111827;">Password:</td>
                                    <td style="color: #374151;">{{ $plainPassword }}</td>
                                </tr>
                            </table>

                            <p style="margin-top: 25px; font-size: 15px; color: #374151;">
                                You can log in using the button below:
                            </p>

                            <p style="text-align: center; margin: 25px 0;">
                                <a href="{{ config('app.url') }}/admin/login" 
                                    style="background-color: #2563eb; color: #ffffff; text-decoration: none; padding: 12px 25px; border-radius: 6px; font-weight: 600; display: inline-block;">
                                    Login to Dashboard
                                </a>
                            </p>

                            <p style="font-size: 14px; line-height: 1.6; color: #6b7280;">
                                Please make sure to change your password after your first login for security purposes.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background: #f0f4f9; padding: 15px; text-align: center; font-size: 12px; color: #555;">
                            © {{ date('Y') }} Keysoft ERP System. All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
