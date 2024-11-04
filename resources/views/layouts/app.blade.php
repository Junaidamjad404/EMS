<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Toastr CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />



        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        
        <!-- Toastr JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
    // Check if the user is authenticated before proceeding
    if ({{ auth()->check() ? 'true' : 'false' }}) {
        const userId = {{ auth()->user()->id }};
        const pusherKey = '{{ env('PUSHER_APP_KEY') }}';
        const pusherCluster = '{{ env('PUSHER_APP_CLUSTER') }}';

        Pusher.logToConsole = true; // Enable logging for Pusher

        // Initialize Pusher
        const pusher = new Pusher(pusherKey, {
            cluster: pusherCluster,
        });

        // Subscribe to the private user channel
        const channel = pusher.subscribe(`user.${userId}`);

        // Listen for the NotificationSent event
        channel.bind('NotificationSent', function(data) {

            // Display the notification using Toastr
            toastr.info(data.message, 'New Notification', {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right', // You can change the position as needed
                timeOut: 10000, // Display for 10 seconds
                extendedTimeOut: 5000, // Additional time when hovering
            });
        });
    }
});

        </script>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
