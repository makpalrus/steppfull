<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('moderator.events.index', compact('events'));
    }

    public function create()
    {
        return view('moderator.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'type' => 'required|in:webinar,workshop,meeting',
        ]);
        
        Event::create($request->all());
        return redirect()->route('moderator.events.index')->with('success', '✅ Мероприятие добавлено');
    }

    public function edit(Event $event)
    {
        return view('moderator.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'type' => 'required|in:webinar,workshop,meeting',
        ]);
        
        $event->update($request->all());
        return redirect()->route('moderator.events.index')->with('success', '✅ Мероприятие обновлено');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return back()->with('success', '🗑 Мероприятие удалено');
    }
}