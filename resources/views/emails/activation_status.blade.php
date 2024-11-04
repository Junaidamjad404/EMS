{{-- resources/views/emails/activation_status.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 5px;
        }
        h1 {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Account has been {{ $status  }}!</h'true'>
        <p>Dear {{ $user->name }},</p>
        <p>Your account has been {{ $status  }} by the admin.</p>
        <p>If you have any questions, feelasfdsa free to reach out.</p>
    </div>
</body>
</html>
