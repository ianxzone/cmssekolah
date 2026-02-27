<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('start_time', '>=', now())
            ->orderBy('start_time', 'asc')
            ->paginate(6);

        return view('events.index', compact('events'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);

        return view('events.show', compact('event'));
    }
}
