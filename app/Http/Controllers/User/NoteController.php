<?php

namespace App\Http\Controllers\User;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Http\Requests\User\StoreNoteRequest;
use App\Http\Controllers\Controller;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::orderBy('updated_at', 'desc')->get();
        return view('user.note.index', compact('notes'));
    }

    public function show($id)
    {
        $note = Note::findOrFail($id);
        $this->checkPermission($note->user_id);

        return view('user.note.show', compact('note'));
    }

    public function ssd(Request $request)
    {
        $query = Note::query()->where('user_id', auth()->id());
        if ($request->s) {
            $query->where('title', 'like', "%$request->s%")
                ->orWhereFullText('content', $request->s);
        }
        $notes = $query->orderBy('updated_at', 'desc')->get();
        return view('user.components.notes', compact('notes'))->render();
    }

    public function create()
    {
        return view('user.note.create');
    }

    public function store(StoreNoteRequest $request)
    {
        Note::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return to_route('note.index')->with(['success' => 'You create a new note.']);
    }

    public function update($id, StoreNoteRequest $request)
    {
        $note = Note::findOrFail($id);
        $this->checkPermission($note->user_id);

        $note->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);
        return to_route('note.index')->with(['success' => 'That note is updated.']);
    }

    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $this->checkPermission($note->user_id);

        $note->delete();
        return response()->json(['message' => 'success'], 200);
    }

    private function checkPermission($id)
    {
        if (auth()->id() != $id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
