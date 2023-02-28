<?php

namespace App\Http\Controllers\Admin;

use App\Models\LibraryType;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLibraryTypeRequest;
use App\Http\Requests\Admin\UpdateLibraryTypeRequest;

class LibraryTypeController extends Controller
{
    public function index()
    {
        $this->checkPermission('view library type');
        return view('admin.library_type.index');
    }

    public function ssd(Request $request)
    {
        $this->checkPermission('view library type');

        $types = LibraryType::query();
        return Datatables::of($types)
            ->addColumn('plus_icon', function ($each) {
                return null;
            })
            ->editColumn('color', function ($each) {
                $circle = '';
                $circle = '<span class="color-circle" style="background:' . $each->color . '"></span>';
                return $circle;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $info_icon = '';
                $delete_icon = '';

                if (auth()->user()->can('edit library type')) {
                    $edit_icon = '<a href="' . route('library_type.edit', $each->id) . '"><i class="bi bi-pencil-square"></i></a>';
                }
                if (auth()->user()->can('edit library type')) {
                    $delete_icon = '<a href="javascript:void(0);" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bi bi-trash"></i></a>';
                }

                return '<div class="action-icons">' . $edit_icon . $info_icon . $delete_icon . '</div>';
            })
            ->rawColumns(['color', 'action'])
            ->make(true);
    }

    public function create()
    {
        $this->checkPermission('create library type');
        return view('admin.library_type.create');
    }

    public function store(StoreLibraryTypeRequest $request)
    {
        $this->checkPermission('create library type');

        $type = LibraryType::create([
            'name' => $request->name,
            'color' => $request->color,
        ]);
        return redirect()->route('library_type.index')->with(['success' => 'New type is created.']);
    }

    public function edit($id)
    {
        $this->checkPermission('edit library type');

        $type = LibraryType::findOrFail($id);
        return view('admin.library_type.edit', compact('type'));
    }

    public function update($id, UpdateLibraryTypeRequest $request)
    {
        $this->checkPermission('edit library type');

        $type = LibraryType::findOrFail($id);
        $type->update([
            'name' => $request->name,
            'color' => $request->color,
        ]);
        return redirect()->route('library_type.index')->with(['success' => 'That type is updated.']);
    }

    public function destroy($id)
    {
        $this->checkPermission('delete library type');

        $type = LibraryType::findOrFail($id);
        $type->delete();
        return response()->json(['message' => 'success'], 200);
    }

    private function checkPermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
