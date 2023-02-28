<?php

namespace App\Http\Controllers\User;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function index()
    {
        $lists = Event::where('user_id', auth()->id())->get();
        $events = [];
        foreach ($lists ?? [] as $list) {
            $events[] = [
                'id' => $list->id,
                'title' => $list->title,
                'start' => $list->start_date,
                'end' => $list->end_date,
                'color' => $list->color,
            ];
        }
        return view('user.event.index', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'start_date' => 'required',
            'end_date' => 'required',
            'color' => 'required',
        ]);
        $event = Event::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'color' => $request->color,
        ]);

        return response()->json($event, 200);
    }

    public function update($id, Request $request)
    {
        $event = Event::findOrFail($id);
        $this->checkPermission($event->user_id);

        $event->update([
            'title' => $request->title ? $request->title : $event->title,
            'start_date' => $request->start_date ? $request->start_date : $event->start_date,
            'end_date' => $request->end_date ? $request->end_date : $event->end_date,
            'color' => $request->color ? $request->color : $event->color,
        ]);

        return response()->json($event, 200);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $this->checkPermission($event->user_id);

        $event->delete();
        return response()->json(['id' => $id], 200);
    }

    private function checkPermission($id)
    {
        if (auth()->id() != $id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
