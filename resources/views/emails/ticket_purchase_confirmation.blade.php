<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Purchase Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #4CAF50;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
        }

        .ticket-details {
            border-top: 2px solid #4CAF50;
            padding-top: 10px;
            margin-top: 20px;
        }

        .benefits {
            margin-top: 20px;
            padding: 10px;
            background: #f1f1f1;
            border-left: 5px solid #4CAF50;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Thank You for Your Purchase!</h1>
        <p>Hello {{ $purchase->user->name }},</p>
        <p>Thank you for purchasing tickets for the event: <strong>{{ ($purchase->event->title) }}</strong>.</p>

        <div class="ticket-details">
            <p><strong>Ticket Type:</strong> {{ $purchase->ticketType->name }}</p>
            <p><strong>Quantity:</strong> {{ $purchase->quantity }}</p>
            <p><strong>Total Price:</strong> ${{ number_format($purchase->total_price, 2) }}</p>
        </div>

        <div class="benefits">
            <h3>Benefits of Your Ticket:</h3>
            <ul>
                @foreach (explode(',', $purchase->ticketType->benefits) as $benefit)
                    <li>{{ $benefit }}</li>
                @endforeach
            </ul>
        </div>

        <p>We look forward to seeing you at the event!</p>
        <p class="footer">Best regards,<br>Your Event Team</p>
    </div>
</body>

</html>
