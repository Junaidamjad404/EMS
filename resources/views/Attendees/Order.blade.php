@extends('layouts.main')
@section('content')
    <div class="event-details space-top space-extra-bottom">
        <div class="container">

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" role="tabpanel">
                    <div class="row" >

                        @foreach ($Tickets as $Ticket)
                            <div class="col-lg-4  mb-4" >
                                <div class="event-style1" >
                                    <div class="event-img">
                                        @if ($Ticket->event->images->isNotEmpty())
                                            <img src="{{ asset('storage/' . $Ticket->event->images->first()->image_url) }}"
                                                alt="{{ $Ticket->event->title }}" class="w-full h-96 object-cover">
                                        @else
                                            <img src="{{ asset('assets/img/events/e-1-1.jpg') }}" alt="e 1 1">
                                        @endif
                                        <div class="event-tags">
                                            <a href="event-details.html">{{ $Ticket->event->category->name }}</a>
                                        </div>
                                        <div class="event-date">
                                            <span>{{ \Carbon\Carbon::parse($Ticket->event->date)->format(' j') }}</span>
                                            {{ \Carbon\Carbon::parse($Ticket->event->date)->format('F') }}
                                        </div>
                                    </div>
                                    <div class="event-content">
                                        <div class="event-meta">
                                            <ul>
                                                <li>
                                                    <span><i
                                                            class="fas fa-clock"></i>{{ \Carbon\Carbon::parse($Ticket->event->date)->format('g:i A') }}</span>
                                                </li>
                                                <li>
                                                    <span><i
                                                            class="fas fa-map-marker-alt"></i>{{ $Ticket->event->location }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <h3 class="event-title h5"><a
                                                href="{{ route('user.event.details',['id'=>$Ticket->event_id]) }}">{{ $Ticket->event->title }}</a>
                                        </h3>
                                        <p class="event-text">{{ $Ticket->event->description }}</p>
                                        <div class="event-footer">
                                            <a href="{{ route('user.event.details',['id'=>$Ticket->event_id]) }}" class="event-link">{{ $Ticket->ticketType->name }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
