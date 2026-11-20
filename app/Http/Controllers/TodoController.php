<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class TodoController extends Controller
{
    // Post
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'assignee' => 'nullable|string',
            'due_date' => 'required|date|after_or_equal:today',
            'time_tracked' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:pending,open,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
        ]);

        $validated['time_tracked'] = $validated['time_tracked'] ?? 0;
        $validated['status']       = $validated['status'] ?? 'pending';

        $todo = Todo::create($validated);
        return response()->json($todo, 201);
    }

    //get dan excel
    public function export(Request $request)
    {
        $todos = Todo::query()
            ->when($request->title, fn($q, $v) => $q->where('title', 'like', "%{$v}%"))
            ->when($request->assignee, fn($q, $v) => $q->whereIn('assignee', explode(',', $v)))
            ->when($request->start, fn($q, $v) => $q->whereDate('due_date', '>=', $v))
            ->when($request->end, fn($q, $v) => $q->whereDate('due_date', '<=', $v))
            ->when($request->filled('min'), fn($q) => $q->where('time_tracked', '>=', $request->min))
            ->when($request->filled('max'), fn($q) => $q->where('time_tracked', '<=', $request->max))
            ->when($request->status, fn($q, $v) => $q->whereIn('status', explode(',', $v)))
            ->when($request->priority, fn($q, $v) => $q->whereIn('priority', explode(',', $v)))
            ->get();

        $rows = $todos->map(fn($item)=>[
            'title' => $item->title,
            'assignee' => $item->assignee ?? '-',
            'due_date' => $item->due_date,
            'time_tracked' => $item->time_tracked,
            'status' => $item->status,
            'priority' => $item->priority,
        ]);

        $rows->push([
            'title' => 'Total Todos: ' . $todos->count(),
            'assignee' => '',
            'due_date' => '',
            'time_tracked' => 'Total Time: ' . $todos->sum('time_tracked'),
            'status' => '',
            'priority' => '',
        ]);

        return (new FastExcel($rows))->download('laporantodo.xlsx');
    }
}
