@extends('layouts.admin')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="calendar__container">
    <h1>Custom Calendar</h1>
    <div class="row">
        <div class="col">
            <h3>{{ $monthYear }}</h3>
            <a href="{{ route('calendar', ['month' => $prevMonth]) }}" class="btn btn-primary">Previous Month</a>
            <a href="{{ route('calendar', ['month' => $nextMonth]) }}" class="btn btn-primary">Next Month</a>
            <table class="table table-bordered">
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
                            <div class="date__box"></div>
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

@endsection