<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <!-- resources/views/emails/event-created-for-attendee.blade.php -->

<p>Dear {{ $attendee->name }},</p>

<p>We are happy to inform you that your event titled "<strong>{{ $event->title }}</strong>" has been successfully created.</p>

<p>Your event is currently under review and pending approval. You will receive a confirmation email once it has been reviewed and approved by our team.</p>

<p><strong>Event Details:</strong></p>
<ul>
    <li><strong>Title:</strong> {{ $event->title }}</li>
    <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('F j, Y, g:i a') }}</li>
    <li><strong>Location:</strong> {{ $event->location }}</li>
</ul>

<p>Thank you for using our platform to organize your event!</p>

<p>Best regards,<br>
The Event Management Team</p>

</body>
</html>