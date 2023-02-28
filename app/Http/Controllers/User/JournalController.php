<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreJournalRequest;
use App\Models\Journal;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class JournalController extends Controller
{
    public function index()
    {
        return view('user.journal.index');
    }

    public function show($id)
    {
        $journal = Journal::findOrFail($id);
        $this->checkPermission($journal->user_id);

        return view('user.journal.show', compact('journal'));
    }

    public function ssd(Request $request)
    {
        $journals = Journal::query()->where('user_id', auth()->id());
        return Datatables::of($journals)
            ->addColumn('plus_icon', function ($each) {
                return null;
            })
            ->editColumn('title', function ($each) {
                $link = '<a href="' . route('journal.show', $each->id) . '" class="go-to-link">' . $each->title . '</a>';
                return $link;
            })
            ->editColumn('rating', function ($each) {
                $emoji = '';
                switch ($each->rating) {
                    case 5:
                        $emoji = '<i class="bi bi-emoji-laughing-fill text-success fs-3" title="Outstanding"></i>';
                        break;
                    case 4:
                        $emoji = '<i class="bi bi-emoji-smile-fill text-success fs-3" title="Pretty Good"></i>';
                        break;
                    case 3:
                        $emoji = '<i class="bi bi-emoji-neutral-fill text-info fs-3" title="Normal Day"></i>';
                        break;
                    case 2:
                        $emoji = '<i class="bi bi-emoji-frown-fill text-secondary fs-3" title="Not Great"></i>';
                        break;
                    case 1:
                        $emoji = '<i class="bi bi-emoji-angry-fill text-danger fs-3" title="Hard"></i>';
                        break;

                    default:
                        $emoji = '-';
                        break;
                }
                return $emoji;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $info_icon = '';
                $delete_icon = '';

                $edit_icon = '<a href="' . route('journal.edit', $each->id) . '" title="Edit"><i class="bi bi-pencil-square"></i></a>';
                $delete_icon = '<a href="javascript:void(0);" class="text-danger delete-btn" data-id="' . $each->id . '" title="Delete"><i class="bi bi-trash"></i></a>';

                return '<div class="action-icons">' . $edit_icon . $info_icon . $delete_icon . '</div>';
            })
            ->rawColumns(['title', 'rating', 'action'])
            ->make(true);
    }

    public function create()
    {
        return view('user.journal.create');
    }

    public function store(StoreJournalRequest $request)
    {
        $journal = Journal::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'date' => $request->date,
            ],
            [
                'title' => $request->title,
                'content' => $request->content,
                'rating' => $request->rating,
            ]
        );

        return to_route('journal.index')->with(['success' => 'You create a new journal.']);
    }

    public function edit($id)
    {
        $journal = Journal::findOrFail($id);
        $this->checkPermission($journal->user_id);

        return view('user.journal.edit', compact('journal'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'date' => "required|unique:journals,date,{$id},id,user_id," . auth()->id(),
            // 'date' => 'required|unique:journals,date,' . $id,
            'rating' => 'required'
        ]);

        $journal = Journal::findOrFail($id);
        $this->checkPermission($journal->user_id);

        $journal->update([
            'title' => $request->title,
            'date' => $request->date,
            'content' => $request->content,
            'rating' => $request->rating,
        ]);
        return response()->json(['message' => 'success'], 200);
    }

    public function destroy($id)
    {
        $journal = Journal::findOrFail($id);
        $this->checkPermission($journal->user_id);

        $journal->delete();
        return response()->json(['message' => 'success'], 200);
    }

    private function checkPermission($id)
    {
        if (auth()->id() != $id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
