<!-- resources/views/emails/user_credentials.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Account Created</title>
</head>
<body>
    <h2>Hello {{ $user->name }},</h2>
    <p>Your account has been created successfully. Here are your login details:</p>

    <ul>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>Password:</strong> {{ $plainPassword }}</li>
    </ul>

    <p>You can log in to the system using the link below:</p>
    <p><a href="{{ url('/login') }}">Login Here</a></p>

    <p>Thank you!</p>
</body>
</html>
