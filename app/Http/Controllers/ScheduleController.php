<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::query();
        
       
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('subject', 'like', "%{$request->search}%")
                  ->orWhere('professor', 'like', "%{$request->search}%")
                  ->orWhere('section', 'like', "%{$request->search}%")
                  ->orWhere('room', 'like', "%{$request->search}%");
            });
        }
    
        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }
    
       
        $allSchedules = Schedule::all(); 
    
        $view = $request->get('view', 'list');
        
        
        if ($view === 'grid') {
            $schedules = $query->orderBy('day')->orderBy('time_start')->get();
        } else {
            $schedules = $query->orderBy('day')->orderBy('time_start')->paginate(15)->withQueryString();
        }
        
        return view('schedule.index', [
            'schedules'    => $schedules,
            'allSchedules' => $allSchedules,
            'view'         => $view,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject'    => 'required|string|max:255',
            'professor'  => 'required|string|max:255',
            'section'    => 'required|string|max:100',
            'year_level' => 'required|string|max:50',
            'day'        => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'time_start' => 'required',
            'time_end'   => 'required|after:time_start',
            'room'       => 'required|string|max:100',
        ]);

        $conflict = $this->detectConflict($data);
        if ($conflict) {
            return back()->with('conflict', $conflict)->withInput();
        }

        Schedule::create($data);
        return back()->with('success', 'Schedule added successfully.');
    }

    public function update(Request $request, Schedule $schedule)
    {
        $data = $request->validate([
            'subject'    => 'required|string|max:255',
            'professor'  => 'required|string|max:255',
            'section'    => 'required|string|max:100',
            'year_level' => 'required|string|max:50',
            'day'        => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'time_start' => 'required',
            'time_end'   => 'required|after:time_start',
            'room'       => 'required|string|max:100',
        ]);

        $conflict = $this->detectConflict($data, $schedule->id);
        if ($conflict) {
            return back()->with('conflict', $conflict)->withInput();
        }

        $schedule->update($data);
        return back()->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Schedule deleted.');
    }

    /**
     * Detect time conflicts:
     * - Same room, same day, overlapping time
     * - Same professor, same day, overlapping time
     * - Same section, same day, overlapping time
     */
    private function detectConflict(array $data, ?int $excludeId = null): ?string
    {
        $query = Schedule::where('day', $data['day'])
            ->where(function ($q) use ($data) {
                $q->where(function ($q2) use ($data) {
                    $q2->where('time_start', '<', $data['time_end'])
                       ->where('time_end', '>', $data['time_start']);
                });
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        // Room conflict
        $roomConflict = (clone $query)->where('room', $data['room'])->first();
        if ($roomConflict) {
            return "Room {$data['room']} is already occupied on {$data['day']} from {$roomConflict->time_start} to {$roomConflict->time_end} ({$roomConflict->subject}).";
        }

        // Professor conflict
        $profConflict = (clone $query)->where('professor', $data['professor'])->first();
        if ($profConflict) {
            return "{$data['professor']} already has a class on {$data['day']} from {$profConflict->time_start} to {$profConflict->time_end} ({$profConflict->subject}).";
        }

        // Section conflict
        $sectionConflict = (clone $query)->where('section', $data['section'])->first();
        if ($sectionConflict) {
            return "Section {$data['section']} already has a class on {$data['day']} from {$sectionConflict->time_start} to {$sectionConflict->time_end} ({$sectionConflict->subject}).";
        }

        return null;
    }
}
