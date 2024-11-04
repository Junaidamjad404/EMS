<x-app-layout>
    <style>
        tbody tr:hover {
            background-color: #f5f5f5;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .form-toggle {
            appearance: none;
            width: 40px;
            height: 20px;
            background-color: #e2e8f0;
            border-radius: 9999px;
            outline: none;
            transition: background-color 0.2s ease;
            position: relative;
        }

        .form-toggle:checked {
            background-color: #3b82f6;
            /* Blue color for "present" */
        }

        .form-toggle:checked::after {
            transform: translateX(20px);
        }

        .form-toggle::after {
            content: "";
            width: 20px;
            height: 20px;
            background-color: white;
            border-radius: 9999px;
            position: absolute;
            top: 0;
            left: 0;
            transition: transform 0.2s ease;
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-3 lg:2x-8 space-y-6">
            <!-- Chart for Event Statistics -->
            <div class="chart-container" style="position: relative; width: 100%; height: 400px;">
                <canvas id="myChart"></canvas>
            </div>
            <!-- Event Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <div class="bg-blue-500 text-white p-4 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Total Events</h2>
                    <p class="text-2xl">{{ $events->total() }}</p>
                </div>

                <div class="bg-green-500 text-white p-4 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Upcoming Events</h2>
                    <p class="text-2xl">{{ array_sum($eventCounts['uncompleted']) }}</p>
                </div>

                <div class="bg-yellow-500 text-white p-4 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Completed Events</h2>
                    <p class="text-2xl">{{ array_sum($eventCounts['completed']) }}</p>
                </div>


            </div>

            @if (Auth::user()->hasPermission('create events'))
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-medium text-gray-900">{{ __('Record') }}</h2>
                    <!-- Primary Button for Creating an Event -->
                    <a href="{{ route('events.create') }}">
                        <x-primary-button>{{ __('Create Event') }}</x-primary-button>
                    </a>
                </div>
            @endif

            @if (session('success'))
                <div id="success-alert" class="items-center p-4 mb-4 text-sm text-green-700 bg-green-300 rounded-lg"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Events Table -->
            <div class="overflow-hidden shadow-md sm:rounded-lg mt-4">
                <div class="overflow-x-auto"> <!-- Added to enable horizontal scrolling -->
                    <table class="min-w-full divide-y divide-gray-200 w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Event Name
                                </th>
                                <th scope="col"
                                    class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Attendance
                                </th>
                                <th scope="col"
                                    class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col"
                                    class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Event Organizer
                                </th>
                                <th scope="col"
                                    class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Event Category
                                </th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ticket Types <!-- New Column -->
                                </th>
                                <th scope="col"
                                    class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description
                                </th>
                                <th scope="col"
                                    class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Location
                                </th>
                                <th scope="col"
                                    class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if (Auth::user()->hasPermission('view events'))

                                @foreach ($events as $event)
                                    <tr
                                        class="{{ $event->date < now() || $event->status == \App\Enums\EventStatus::Cancelled->value ? 'opacity-50 cursor-not-allowed' : '' }}">
                                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                            {{ $event->title }}
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">

                                            <a onclick="openModal({{ $event->id }})"
                                                class="inline-flex items-center " data-event-id="{{ $event->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"
                                                    class="w-6 h-6 ml-4 text-blue-600">
                                                    <path
                                                        d="M192 0c-41.8 0-77.4 26.7-90.5 64L64 64C28.7 64 0 92.7 0 128L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64l-37.5 0C269.4 26.7 233.8 0 192 0zm0 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM128 256a64 64 0 1 1 128 0 64 64 0 1 1 -128 0zM80 432c0-44.2 35.8-80 80-80l64 0c44.2 0 80 35.8 80 80c0 8.8-7.2 16-16 16L96 448c-8.8 0-16-7.2-16-16z" />
                                                </svg>


                                            </a>
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                            {{ $event->date }}
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                            {{ $event->organizer->name }}</td>
                                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                            {{ $event->category->name }}</td>
                                        <td
                                            class="px-3 py-2 whitespace-nowrap text-sm text-blue-600 hover:text-blue-900">
                                            <!-- Icon to View Ticket Types -->
                                            <a href="{{ route('ticket_types.index', $event->id) }}"
                                                class="inline-flex items-center">
                                                <svg class="h-4 w-6 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 30 16" xmlns="http://www.w3.org/2000/svg"
                                                    style="position: relative; top: -4px;">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15 2C7 2 3 8 3 8s4 6 12 6 12-6 12-6-4-6-12-6zm0 4a3 3 0 110 6 3 3 0 010-6z" />
                                                </svg>

                                            </a>

                                            <!-- Icon to Add Existing Ticket Type -->
                                            <a class="addExistingTicketTypesBtn  inline-flex items-center "
                                                data-event-id="{{ $event->id }}">
                                                <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>

                                            </a>
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                            {{ $event->description }}</td>
                                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                            {{ $event->location }}</td>
                                        <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-900">
                                            <span
                                                class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium
                                            {{ $event->status == 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $event->status == 'pending' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $event->status == 'completed' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $event->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($event->status) }}
                                            </span>
                                        </td>

                                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium">

                                            @if (\Carbon\Carbon::parse($event->date)->isFuture())
                                                <a href="{{ route('events.show', $event->id) }}"
                                                    class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                                                    <svg class="h-4 w-6 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 30 16" xmlns="http://www.w3.org/2000/svg"
                                                        style="position: relative; top: -4px;">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15 2C7 2 3 8 3 8s4 6 12 6 12-6 12-6-4-6-12-6zm0 4a3 3 0 110 6 3 3 0 010-6z" />
                                                    </svg>

                                                </a>
                                                @if (Auth::user()->hasPermission('edit events'))
                                                    <a href="{{ route('events.edit', $event->id) }}"
                                                        class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                                                        <svg class="h-6 w-6 " fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M14.121 4.121a3 3 0 00-4.242 0L3 11.586V17h5.414l6.879-6.879a3 3 0 000-4.242z" />
                                                        </svg>
                                                    </a>


                                                    <form id="uploadForm"
                                                        action="{{ route('events.destroy', $event->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center text-red-600 hover:text-red-900"
                                                            onclick="return confirm('Are you sure you want to delete this event ?');">
                                                            <svg class="h-7 w-6 mr-2" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                <span class="text-gray-500">Disabled</span>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                    <div class="px-2 mt-2">
                        {{ $events->links('pagination::tailwind') }} <!-- This will render the pagination links -->
                    </div>
                </div>

            </div>


        </div>

    </div>
    <!-- Modal Structure -->
    <!-- Modal -->
    <!-- Modal Background -->
    <div id="ticketTypesModal"
        class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden max-w-lg  w-full">
            <div class="px-4 py-3 border-b">
                <h3 class="text-lg font-medium">Select Ticket Types</h3>
                <button id="closeModal"
                    class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">&times;</button>
            </div>
            <div class="p-4  h-1/5 overflow-y-auto" style="max-height: 400px;">
                <div id="ticketTypesList" class="space-y-2">
                </div>
            </div>
            <div class="px-4 py-3 border-t">
                <button id="addTicketTypesBtn" class="bg-blue-500 text-white px-4 py-2 rounded">Add</button>
                <button id="closeModalFooterBtn" class="bg-gray-500 text-white px-4 py-2 rounded">Close</button>
            </div>
        </div>
    </div>

    <div id="ticketPurchaseModal"
        class="fixed inset-0 flex items-center justify-center hidden bg-gray-800 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-4 w-80%">
            <h2 class="text-xl font-semibold mb-4">Ticket Purchases</h2>
            <div id="ticketPurchaseList" class="max-h-60 overflow-y-auto mb-4"></div>
            <button onclick="closeModal()" class="mt-2 px-4 py-2 bg-red-600 text-white rounded">Close</button>
        </div>
    </div>





</x-app-layout>

<script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar', // Choose the chart type
        data: {
            labels: @json($eventCounts['months']),
            datasets: [{
                label: 'Completed Events',
                data: @json($eventCounts['completed']),
                backgroundColor: 'rgba(255, 239, 0, 0.6)', // Pale Gold
                borderColor: 'rgba(255, 239, 0, 1)', // Solid Pale Gold
                borderWidth: 1
            }, {
                label: 'Uncompleted Events',
                data: @json($eventCounts['uncompleted']),
                backgroundColor: 'rgba(119, 221, 119, 0.6)', // Pastel Green
                borderColor: 'rgba(119, 221, 119, 1)', // Solid Pastel Green
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    document.getElementById('uploadForm').onsubmit = function() {
        const imageFiles = document.getElementById('promotional_images').files;
        const videoFiles = document.getElementById('promotional_videos').files;

        for (let file of imageFiles) {
            if (!['image/jpeg', 'image/png', 'image/gif'].includes(file.type) || file.size > 2 * 1024 * 1024) {
                alert('Invalid image file! Please upload JPEG, PNG, or GIF files up to 2MB.');
                return false;
            }
        }

        for (let file of videoFiles) {
            if (!['video/mp4', 'video/avi', 'video/mov'].includes(file.type) || file.size > 50 * 1024 * 1024) {
                alert('Invalid video file! Please upload MP4, AVI, or MOV files up to 50MB.');
                return false;
            }
        }

        return true; // Form is valid
    };
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('ticketTypesModal');
        const closeModalBtn = document.getElementById('closeModal');
        const closeModalFooterBtn = document.getElementById('closeModalFooterBtn');
        const addTicketTypesBtn = document.getElementById('addTicketTypesBtn');
        let currentEventId;

        document.addEventListener('click', function(event) {
            const button = event.target.closest('.addExistingTicketTypesBtn');

            if (button) {
                currentEventId = button.getAttribute('data-event-id');
                modal.classList.remove('hidden');

                fetch(`/events/${currentEventId}/api/ticket-types`)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        const ticketTypesList = document.getElementById('ticketTypesList');
                        ticketTypesList.innerHTML = ''; // Clear the list

                        const {
                            availableTicketTypes,
                            eventTicketTypes
                        } = data;
                        console.log(eventTicketTypes)
                        // Create a Map of event ticket types for faster lookup
                        const eventTicketTypeMap = new Map(eventTicketTypes.map(ticket => [ticket
                            .id, ticket
                        ]));

                        availableTicketTypes.forEach(ticketType => {
                            const ticketItem = document.createElement('div');
                            ticketItem.className = 'flex items-center justify-between';

                            // Get assigned ticket with price/quantity if it exists
                            const assignedTicket = eventTicketTypeMap.get(ticketType.id) ||
                            {};
                            const isChecked = assignedTicket.id ? 'checked' : '';
                            const price = assignedTicket.price || '';
                            const quantity = assignedTicket.quantity || '';

                            ticketItem.innerHTML = `
                                <div class="flex items-center">
                                    <input type="checkbox" id="ticketType${ticketType.id}" name="ticket_types[]" value="${ticketType.id}" ${isChecked} class="mr-2">
                                    <label for="ticketType${ticketType.id}" class="text-gray-700">${ticketType.name}</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="number" min="1" placeholder="Quantity" class="border rounded px-2 py-1 w-24 mr-2" id="quantity${ticketType.id}" value="${quantity}">
                                    <input type="number" min="0" placeholder="Price" class="border rounded px-2 py-1 w-24 " id="price${ticketType.id}" value="${price}">

                                </div>
                            `;

                            ticketTypesList.appendChild(ticketItem);
                        });
                    })
                    .catch(error => console.error('Error fetching ticket types:', error));
            }
        });




        closeModalBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        closeModalFooterBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        addTicketTypesBtn.addEventListener('click', function() {
            const selectedTicketTypes = Array.from(document.querySelectorAll(
                'input[name="ticket_types[]"]:checked')).map(input => {
                const priceInput = document.getElementById(
                    `price${input.id.replace('ticketType', '')}`);
                const quantityInput = document.getElementById(
                    `quantity${input.id.replace('ticketType', '')}`);
                return {
                    id: input.value,
                    price: priceInput.value,
                    quantity: quantityInput.value
                };
            });

            console.log('Selected Ticket Types:', selectedTicketTypes);

            fetch(`/events/${currentEventId}/ticket_types/sync`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        ticket_types: selectedTicketTypes
                    })
                })
                .then(response => {
                    if (response.ok) {
                        modal.classList.add('hidden');
                    } else {
                        throw new Error('Network response was not ok.');
                    }
                })
                .catch(error => console.error('Error updating ticket types:', error));
        });
    });

    function openModal(eventId) {
        // Fetch ticket purchases for the selected event
        fetch(`/api/ticket-purchases/${eventId}`)
            .then(response => response.json())
            .then(data => {
                const ticketPurchaseList = document.getElementById('ticketPurchaseList');
                ticketPurchaseList.innerHTML = ''; // Clear previous data

                // Create table structure
                const table = document.createElement('table');
                table.className = 'min-w-full divide-y divide-gray-200';
                table.innerHTML = `
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">User</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Ticket Type</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Event</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Quantity</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Purchased On</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                </tbody>
            `;

                const tbody = table.querySelector('tbody');

                data.forEach(purchase => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-4 py-2">${purchase.user ? purchase.user.name : 'N/A'}</td>
                        <td class="px-4 py-2">${purchase.ticket_type ? purchase.ticket_type.name : 'N/A'}</td>
                        <td class="px-4 py-2">${purchase.event ? purchase.event.title : 'N/A'}</td>
                        <td class="px-4 py-2">${purchase.quantity}</td>
                        <td class="px-4 py-2">${new Date(purchase.created_at).toLocaleDateString('en-GB')}</td>
                        <td class="px-4 py-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="form-toggle" data-id="${purchase.id}" ${purchase.attendance_status === 'present' ? 'checked' : ''}>
                                <span class="ml-2 text-gray-700">${purchase.attendance_status === 'present' ? 'Present' : 'Absent'}</span>
                            </label>
                        </td>
                    `;

                    // Add event listener to the toggle switch
                    const toggle = row.querySelector('.form-toggle');
                    toggle.addEventListener('change', function() {
                        const newStatus = this.checked ? 'present' : 'absent';

                        // Send request to update attendance status
                        fetch(`/api/ticket-purchases/${purchase.id}/attendance`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content'),
                                },
                                body: JSON.stringify({
                                    attendance_status: newStatus
                                }),
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Update the label text based on the new status
                                row.querySelector('span').textContent = newStatus ===
                                    'present' ? 'Present' : 'Absent';
                                alert(data.message); // Show success message
                            })
                            .catch(error => {
                                console.error('Error updating attendance status:', error);
                                alert('Failed to update attendance status.');
                                // Revert the toggle to the previous state if there was an error
                                this.checked = !this.checked;
                            });
                    });

                    tbody.appendChild(row);
                });



                ticketPurchaseList.appendChild(table); // Add the table to the modal
                // Open the modal
                document.getElementById('ticketPurchaseModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching ticket purchases:', error);
            });
    }

    function closeModal() {
        document.getElementById('ticketPurchaseModal').classList.add('hidden');
    }
</script>
