<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index()
    {
        // Extract unique subjects from the schedules table
        // with aggregated info per subject
        $subjects = DB::table('schedules')
            ->select(
                'subject',
                DB::raw('COUNT(*) as schedule_count'),
                DB::raw('GROUP_CONCAT(DISTINCT section ORDER BY section SEPARATOR ", ") as sections'),
                DB::raw('GROUP_CONCAT(DISTINCT professor ORDER BY professor SEPARATOR ", ") as professors'),
                DB::raw('GROUP_CONCAT(DISTINCT day ORDER BY day SEPARATOR ", ") as days')
            )
            ->groupBy('subject')
            ->orderBy('subject')
            ->get();

        $totalSubjects  = $subjects->count();
        $totalSchedules = DB::table('schedules')->count();
        $totalSections  = DB::table('schedules')->distinct('section')->count('section');

        return view('subjects.index', compact(
            'subjects',
            'totalSubjects',
            'totalSchedules',
            'totalSections'
        ));
    }

    public function create() { return redirect()->route('subjects.index'); }
    public function store(Request $request) { return redirect()->route('subjects.index'); }
    public function show($id) { return redirect()->route('subjects.index'); }
    public function edit($id) { return redirect()->route('subjects.index'); }
    public function update(Request $request, $id) { return redirect()->route('subjects.index'); }
    public function destroy($id) { return redirect()->route('subjects.index'); }
}