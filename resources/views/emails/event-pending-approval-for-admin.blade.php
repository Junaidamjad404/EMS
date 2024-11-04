<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <!-- resources/views/emails/event-pending-approval-for-admin.blade.php -->

<p>Dear Admin,</p>

<p>A new event titled "<strong>{{ $event->title }}</strong>" has been created by {{ $attendee->name }} and is currently pending your approval.</p>

<p><strong>Event Details:</strong></p>
<ul>
    <li><strong>Title:</strong> {{ $event->title }}</li>
    <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('F j, Y, g:i a') }}</li>
    <li><strong>Location:</strong> {{ $event->location }}</li>
    <li><strong>Created by:</strong> {{ $attendee->name }} ({{ $attendee->email }})</li>
</ul>

<p>Please review the event and approve or reject it.</p>

<p>To approve or reject the event, visit the admin dashboard.</p>

<p>Best regards,<br>
The Event Management Team</p>

</body>
</html>
