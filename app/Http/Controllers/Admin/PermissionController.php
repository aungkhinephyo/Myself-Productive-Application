<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Admin\StorePermissionRequest;
use App\Http\Requests\Admin\UpdatePermissionRequest;

class PermissionController extends Controller
{
    public function index()
    {
        $this->checkPermission('view permission');
        return view('admin.permission.index');
    }

    public function ssd(Request $request)
    {
        $this->checkPermission('view permission');

        $permissions = Permission::query();
        return Datatables::of($permissions)
            ->addColumn('plus_icon', function ($each) {
                return null;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $info_icon = '';
                $delete_icon = '';

                if (auth()->user()->can('edit permission')) {
                    $edit_icon = '<a href="' . route('permission.edit', $each->id) . '"><i class="bi bi-pencil-square"></i></a>';
                }
                if (auth()->user()->can('delete permission')) {
                    $delete_icon = '<a href="javascript:void(0);" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bi bi-trash"></i></a>';
                }

                return '<div class="action-icons">' . $edit_icon . $info_icon . $delete_icon . '</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $this->checkPermission('create permission');
        return view('admin.permission.create');
    }

    public function store(StorePermissionRequest $request)
    {
        $this->checkPermission('create permission');

        Permission::create([
            'name' => $request->name,
        ]);

        return redirect()->route('permission.index')->with(['success' => 'New permission is created.']);
    }

    public function edit($id)
    {
        $this->checkPermission('edit permission');

        $permission = Permission::findOrFail($id);
        return view('admin.permission.edit', compact('permission'));
    }

    public function update($id, UpdatePermissionRequest $request)
    {
        $this->checkPermission('edit permission');

        $permission = Permission::findOrFail($id);
        $permission->update([
            'name' => $request->name,
        ]);
        return redirect()->route('permission.index')->with(['success' => 'That permission is updated.']);
    }

    public function destroy($id)
    {
        $this->checkPermission('delete permission');

        $permission = Permission::findOrFail($id);
        $permission->delete();
        return response()->json(['message' => 'success'], 200);
    }

    private function checkPermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
