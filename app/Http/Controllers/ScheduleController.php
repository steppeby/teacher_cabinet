<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Exports\SchedulesExport;
use Maatwebsite\Excel\Facades\Excel;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Schedule::query();

        // Фильтрация по дате
        if ($request->filled('day')) {
            $query->whereDate('date', $request->day);
        }
        // Фильтрация по неделям
        if ($request->filled('week')) {
        $query->whereBetween('date', [
            now()->startOfWeek()->addWeeks($request->week - 1),
            now()->startOfWeek()->addWeeks($request->week)->subDay()
        ]);
        }
        // Фильтрация по месяцу
        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }

        // Фильтрация по году
        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }

        $schedules = $query->orderBy('date', 'asc')->get();

        return view('schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('schedules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'auditorium' => 'required|string',
            'group' => 'required|string',
        ]);

        Schedule::create($validated);

        return redirect()->route('schedules.index')
            ->with('success', 'Расписание добавлено!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        return view('schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        //
        return view('schedules.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
        $validated = $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'auditorium' => 'required|string|max:255',
            'group' => 'required|string|max:255',
        ]);

        $schedule->update($validated);

        return redirect()->route('schedules.index')->with('success', 'Расписание обновлено!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        //
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Расписание удалено!');
    }
    public function exportExcel()
    {
        return Excel::download(new SchedulesExport, 'schedules.xlsx');
    }
}
