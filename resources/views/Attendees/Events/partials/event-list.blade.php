 <div class="row align-items-center justify-content-center justify-content-lg-between">
     <div class="col-auto mb-40">
         <p class="event-title-count"> {{ $events->count() }} Search results Found
            
         </p>
     </div>
 </div>
 <div class="row">
     @foreach ($events as $event)
         <div class="col-md-6 col-lg-4 filter-item Business Art More">
             <div class="event-style1">
                 <div class="event-img">
                     @if ($event->images->isNotEmpty())
                         <img src="{{ asset('storage/' . $event->images->first()->image_url) }}" alt="{{ $event->title }}"
                             class="w-full h-96 object-cover">
                     @else
                         <img src="{{ asset('assets/img/events/e-1-1.jpg') }}" alt="e 1 1">
                     @endif
                     <div class="event-tags">
                         <a href="event-details.html">{{ $event->category->name }}</a>
                     </div>
                     <div class="event-date">
                         <span>{{ \Carbon\Carbon::parse($event->date)->format(' j') }}</span>
                         {{ \Carbon\Carbon::parse($event->date)->format('F') }}
                     </div>
                 </div>
                 <div class="event-content">
                     <div class="event-meta">
                         <ul>
                             <li>
                                 <span><i
                                         class="fas fa-clock"></i>{{ \Carbon\Carbon::parse($event->date)->format('g:i A') }}</span>
                             </li>
                             <li>
                                 <span><i class="fas fa-map-marker-alt"></i>{{ $event->location }}</span>
                             </li>
                         </ul>
                     </div>
                     <h3 class="event-title h5"><a href="{{ route('user.event.details',['id'=>$event->id]) }}">{{ $event->title }}</a>
                     </h3>
                     <p class="event-text">{{ $event->description }}</p>
                     <div class="event-footer">
                         <a href="{{ route('user.event.details',['id'=>$event->id]) }}" class="event-link">Tickets & Details</a>
                     </div>
                 </div>
             </div>
         </div>
     @endforeach
 </div>
