<?php

namespace App\Http\Controllers\Admin;

use App\Models\TodolistType;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTodolistTypeRequest;
use App\Http\Requests\Admin\UpdateTodolistTypeRequest;

class TodolistTypeController extends Controller
{
    public function index()
    {
        $this->checkPermission('view todolist type');
        return view('admin.todolist_type.index');
    }

    public function ssd(Request $request)
    {
        $this->checkPermission('view todolist type');

        $types = TodolistType::query();
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

                if (auth()->user()->can('edit todolist type')) {
                    $edit_icon = '<a href="' . route('todolist_type.edit', $each->id) . '"><i class="bi bi-pencil-square"></i></a>';
                }
                if (auth()->user()->can('delete todolist type')) {
                    $delete_icon = '<a href="javascript:void(0);" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bi bi-trash"></i></a>';
                }

                return '<div class="action-icons">' . $edit_icon . $info_icon . $delete_icon . '</div>';
            })
            ->rawColumns(['color', 'action'])
            ->make(true);
    }

    public function create()
    {
        $this->checkPermission('create todolist type');
        return view('admin.todolist_type.create');
    }

    public function store(StoreTodolistTypeRequest $request)
    {
        $this->checkPermission('create todolist type');

        $type = TodolistType::create([
            'name' => $request->name,
            'color' => $request->color,
        ]);
        return redirect()->route('todolist_type.index')->with(['success' => 'New type is created.']);
    }

    public function edit($id)
    {
        $this->checkPermission('edit todolist type');

        $type = TodolistType::findOrFail($id);
        return view('admin.todolist_type.edit', compact('type'));
    }

    public function update($id, UpdateTodolistTypeRequest $request)
    {
        $this->checkPermission('edit todolist type');

        $type = TodolistType::findOrFail($id);
        $type->update([
            'name' => $request->name,
            'color' => $request->color,
        ]);
        return redirect()->route('todolist_type.index')->with(['success' => 'That type is updated.']);
    }

    public function destroy($id)
    {
        $this->checkPermission('delete todolist type');

        $type = TodolistType::findOrFail($id);
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
