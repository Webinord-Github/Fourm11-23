@extends('layouts.mainheader')

@section('content')

<div class="container">
    @if($page->content)
    <p>{!! $page->content !!}</p>
    @endif

</div>

@if($page->url == 'boite-a-outils')
@include('frontend.tools')
@include('frontend.partials.scripts')
@endif

@if($page->url == 'lexique')
@include('frontend.lexique')
@include('frontend.partials.scripts')
@endif

@if($page->url == 'forum')
@include('frontend.forum')
@include('frontend.partials.scripts')
@endif

@if($page->id == 1)
@foreach($users as $user)
<div class="member__card__container">
    <div class="member__card">
        <div class="member__infos">
            <img src="{{asset('storage/medias/' . $user->image)}}" alt="">
            <p><a href="{{ route('profile.show', ['id' => $user->id]) }}">{{$user->firstname}} {{$user->lastname}}</a></p>
        </div>
    </div>
</div>
@endforeach

@endif
@if($page->id == 7)
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@foreach($events as $event)
@endforeach
<div class="calendar__container">
    <h1>Calendrier des événements</h1>
    <div class="row">
        <div class="col">
            <h3>{{ $monthYear }}</h3>
            <a href="{{ url($page->url, ['month' => $prevMonth]) }}" class="btn btn-primary"><</a>
            <a href="{{ url($page->url, ['month' => $nextMonth]) }}" class="btn btn-primary">></a>



            <table class="table table-bordered calendar__table">
                <thead>
                    <tr>
                        <th>Sun</th>
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thu</th>
                        <th>Fri</th>
                        <th>Sat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($calendar as $week)
                    <tr>
                        @foreach ($week as $day)
                        <td class="date__top">{{ \Carbon\Carbon::parse($day['date'])->format('d') }}

                            <div class="date__box">
                                @foreach($events as $event)
                                @if(\Carbon\Carbon::parse($event->start_at)->format('Y-m-d') == $day['date'])

                                <div class="calendar__event">{{$event->title}}</div>
                                <div class="event__popup__container">
                                    <div class="event__popup">
                                        <div class="event__popup__top">
                                            <p>Événement</p>
                                            <i class="fa fa-close event__popup__close"></i>
                                        </div>
                                        <div class="event__popup__content">
                                            <div class="event__description">
                                                <div class="event__location">
                                                    <p class="event__date">{{ \Carbon\Carbon::parse($event->start_at)->isoFormat('D MMMM YYYY') }}</p>
                                                    <i class="fa fa-map-marker"></i>
                                                    <p class="event__address">5600, rue Hochelaga, suite 160 Montréal (Qc) H1N 3L7</p>
                                                </div>
                                                <div class="event__title">
                                                    <h3>{{$event->title}}</h3>
                                                </div>
                                                <div class="event__desc__html">
                                                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Debitis ipsum inventore iusto quis earum saepe accusantium sunt tenetur. Unde adipisci animi iure labore illum earum deleniti perferendis repellat maiores. Sed!</p>
                                                </div>
                                                <div class="event__cta__container">
                                                    <a class="event__register" href="">Inscription</a>
                                                    <a class="event__details" href="">Plus de détails</a>
                                                </div>
                                            </div>
                                            <div class="event__image__container">
                                                <img src="https://placehold.co/400x200" alt="" class="event__image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let calendarEvents = document.querySelectorAll(".calendar__event")
    let eventCloses = document.querySelectorAll(".event__popup__close")
    for (let calendarEvent of calendarEvents) {
        calendarEvent.addEventListener("click", e => {
            e.target.nextElementSibling.classList.add("flex")
        })
    }
    for (let eventClose of eventCloses) {
        eventClose.addEventListener("click", c => {
            c.target.closest(".event__popup__container").classList.remove("flex")
        })
    }
</script>
@endif

@endsection