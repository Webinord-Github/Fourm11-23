<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalendarEvent;
use Carbon\Carbon;
use App\Models\Page;

class CalendarController extends Controller
{
    public function index($month = null)
    {

        $currentDate = $month ? Carbon::parse($month) : Carbon::now();

        $monthYear = $currentDate->translatedFormat('F Y');
        $prevMonth = $currentDate->copy()->subMonth()->format('Y-m');
        $nextMonth = $currentDate->copy()->addMonth()->format('Y-m');

        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();

        // Ensure the start of the calendar grid is a Sunday
        $startCalendar = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $endCalendar = $endOfMonth->copy()->endOfWeek(Carbon::SATURDAY);

        $calendar = [];
        $week = [];
        $currentDay = $startCalendar->copy();

        while ($currentDay <= $endCalendar) {
            $week[] = [
                'date' => $currentDay->format('Y-m-d'),
                // Add other event-related data here if needed
            ];

            if ($currentDay->dayOfWeek === Carbon::SATURDAY) {
                $calendar[] = $week;
                $week = [];
            }

            $currentDay->addDay();
        }

        return view('admin.calendar.index', [
            'calendar' => $calendar,
            'monthYear' => $monthYear,
            'prevMonth' => $prevMonth,
            'nextMonth' => $nextMonth,
        ]);
    }
}
