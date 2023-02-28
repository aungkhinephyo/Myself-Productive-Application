<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Todolist;
use App\Models\TodolistType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TodolistController extends Controller
{
    public function index()
    {
        $types = TodolistType::select('id', 'name')->get();
        return view('user.todolist.index', compact('types'));
    }

    public function todolistData()
    {
        $types = TodolistType::all();
        $todolists = Todolist::where('user_id', auth()->id())->where('date', date('Y-m-d'))->get();
        return view('user.components.todolists', compact('todolists', 'types'))->render();
    }

    public function todolistHistory()
    {
        $start = now()->startOfMonth()->subDay()->format('Y-m-d');
        $end = now()->addDay()->format('Y-m-d');

        $todolists = Todolist::where('user_id', auth()->id())
            ->whereBetween('date', [$start, $end])
            ->get()
            ->groupBy('date');

        // $dates = [];
        // $todolists = [];
        // foreach ($data as $date => $todolist) {
        //     $dates[] = $date;
        //     $todolists[] = $todolist;
        // }
        // return $todolists;
        return view('user.todolist.todolist_history', compact('todolists'));
    }

    public function todolistHistoryData(Request $request)
    {
        $start = now()->startOfMonth()->format('Y-m-d');
        $end = now()->subDay()->format('Y-m-d');


        if ($request->start && $request->end) {
            $start = Carbon::parse($request->start)->format('Y-m-d');
            $end = Carbon::parse($request->end)->format('Y-m-d');
        }

        $todolists = Todolist::where('user_id', auth()->id())
            ->whereBetween('date', [$start, $end]) // it is inclusive
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy('date');

        return view('user.components.todolist_history_data', compact('todolists'))->render();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'todolist_type_id' => 'required',
        ], [
            'todolist_type_id.required' => 'The type field is required.'
        ]);
        Todolist::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'date' => date('Y-m-d'),
            'todolist_type_id' => $request->todolist_type_id,
        ]);

        return response()->json(['message' => 'success'], 200);
    }

    public function update($id, Request $request)
    {
        if ($request->title || $request->todolist_type_id) {
            $request->validate([
                'title' => 'required',
                'todolist_type_id' => 'required',
            ], [
                'todolist_type_id.required' => 'The type field is required.'
            ]);
        }

        $todolist = Todolist::findOrFail($id);
        $this->checkPermission($todolist->user_id);

        $statusChange = $todolist->status == 1 ? 0 : 1;
        $todolist->update([
            'title' => $request->title ? $request->title : $todolist->title,
            'todolist_type_id' => $request->todolist_type_id ? $request->todolist_type_id : $todolist->todolist_type_id,
            'status' => $request->status != '' ? $request->status : $statusChange,
        ]);

        return response()->json(['message' => 'success'], 200);
    }

    public function destroy($id)
    {
        $todolist = Todolist::findOrFail($id);
        $this->checkPermission($todolist->user_id);

        $todolist->delete();
        return response()->json(['message' => 'success'], 200);
    }

    private function checkPermission($id)
    {
        if (auth()->id() != $id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
