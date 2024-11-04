{{-- resources/views/emails/ticket_purchase_confirmation.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Purchase Confirmation</title>
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
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        p {
            color: #555;
        }

        .highlight {
            color: #007bff;
            font-weight: bold;
        }

        .details {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Ticket Purchase Confirmation</h1>
        <p>Thank you for your purchase!</p>

        <div class="details">
            <p><strong>Event Title:</strong> {{ $event->title }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('l, F j, Y') }}</p>
            <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($event->date)->format('g:i A') }}</p>
            <p><strong>Location:</strong> {{ $event->location }}</p>
            
        </div>

        <p>If you have any questions regarding your purchase, feel free to contact us.</p>
        <p>We look forward to seeing you at the event!</p>
    </div>
</body>

</html>
