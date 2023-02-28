<?php

namespace App\Http\Controllers\User;

use App\Models\Library;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreLibraryRequest;
use App\Http\Requests\User\UpdateLibraryRequest;
use App\Models\LibraryType;

class LibraryController extends Controller
{
    public function index()
    {
        return view('user.library.index');
    }

    public function ssd(Request $request)
    {
        $libraries = Library::query()->where('user_id', auth()->id());
        return Datatables::of($libraries)
            ->filterColumn('library_type_id', function ($query, $keyword) {
                $query->whereHas('library_type', function ($q1) use ($keyword) {
                    $q1->where('name', 'like', "%$keyword%");
                });
            })
            ->addColumn('plus_icon', function ($each) {
                return null;
            })
            ->editColumn('title', function ($each) {
                $link = '<a href="' . $each->link . '" class="go-to-link" target="_blank" title="Go to link">' . $each->title . '</a>';
                return $link;
            })
            ->editColumn('library_type_id', function ($each) {
                $color = $each->library_type->color;
                $badge = '<span class="square-badge" style=" background: ' . $color . ' ;">' . $each->library_type->name . '</span>';
                return $badge;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $info_icon = '';
                $delete_icon = '';

                $edit_icon = '<a href="' . route('library.edit', $each->id) . '" title="Edit"><i class="bi bi-pencil-square"></i></a>';
                $delete_icon = '<a href="javascript:void(0);" class="text-danger delete-btn" data-id="' . $each->id . '" title="Delete"><i class="bi bi-trash"></i></a>';

                return '<div class="action-icons">' . $edit_icon . $info_icon . $delete_icon . '</div>';
            })
            ->rawColumns(['title', 'library_type_id', 'action'])
            ->make(true);
    }

    public function create()
    {
        $types = LibraryType::all();
        return view('user.library.create', compact('types'));
    }

    public function store(StoreLibraryRequest $request)
    {

        $library = Library::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'title' => $request->title,
                'link' => $request->link,
            ],
            [
                'library_type_id' => $request->library_type_id
            ]
        );

        return to_route('library.index')->with(['success' => 'New link added.']);
    }

    public function edit($id)
    {
        $library = Library::findOrFail($id);
        $this->checkPermission($library->user_id);

        $types = LibraryType::all();
        return view('user.library.edit', compact('library', 'types'));
    }

    public function update($id, UpdateLibraryRequest $request)
    {
        $library = Library::findOrFail($id);
        $this->checkPermission($library->user_id);

        $library->update([
            'title' => $request->title,
            'link' => $request->link,
            'library_type_id' => $request->library_type_id
        ]);

        return to_route('library.index')->with(['success' => 'Library updated.']);
    }

    public function destroy($id)
    {
        $library = Library::findOrFail($id);
        $this->checkPermission($library->user_id);

        $library->delete();
        return response()->json(['message' => 'success'], 200);
    }

    private function checkPermission($id)
    {
        if (auth()->id() != $id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
