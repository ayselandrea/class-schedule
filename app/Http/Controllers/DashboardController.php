<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = now()->englishDayOfWeek; // e.g. "Monday"

        $selectedDay = $request->input('day');

        $query = Schedule::query();
        if ($selectedDay) {
            $query->where('day', $selectedDay);
        }
        $schedules = $query->orderBy('day')->orderBy('time_start')->get();

        $totalSchedules  = Schedule::count();
        $totalSubjects   = Schedule::distinct('subject')->count('subject');
        $totalProfessors = Schedule::distinct('professor')->count('professor');
        $totalRooms      = Schedule::distinct('room')->count('room');
        $totalUsers      = User::count();

        return view('dashboard.index', compact(
            'schedules', 'selectedDay',
            'totalSchedules', 'totalSubjects',
            'totalProfessors', 'totalRooms', 'totalUsers'
        ));
    }
}
