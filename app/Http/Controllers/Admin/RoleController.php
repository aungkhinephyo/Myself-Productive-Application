<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $this->checkPermission('view role');
        return view('admin.role.index');
    }

    public function ssd(Request $request)
    {
        $this->checkPermission('view role');

        $roles = Role::query();
        return Datatables::of($roles)
            ->filterColumn('permissions', function ($query, $keyword) {
                $query->whereHas('permissions', function ($q1) use ($keyword) {
                    $q1->where('name', 'like', "%$keyword%");
                });
            })
            ->addColumn('plus_icon', function ($each) {
                return null;
            })
            ->addColumn('permissions', function ($each) {
                $list = '';
                foreach ($each->permissions as $permission) {
                    $list .= '<span class="badge rounded-pill bg-primary py-2 m-1">' . $permission->name . '</span>';
                }
                return '<div>' . $list . '</div>';
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $info_icon = '';
                $delete_icon = '';

                if (auth()->user()->can('edit role')) {
                    $edit_icon = '<a href="' . route('role.edit', $each->id) . '"><i class="bi bi-pencil-square"></i></a>';
                }
                if (auth()->user()->can('delete role')) {
                    $delete_icon = '<a href="javascript:void(0);" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bi bi-trash"></i></a>';
                }

                return '<div class="action-icons">' . $edit_icon . $info_icon . $delete_icon . '</div>';
            })
            ->rawColumns(['permissions', 'action'])
            ->make(true);
    }

    public function create()
    {
        $this->checkPermission('create role');

        $permissions = Permission::all();
        return view('admin.role.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $this->checkPermission('create role');

        $role = Role::create([
            'name' => $request->name,
        ]);
        $role->syncPermissions($request->permission);
        return redirect()->route('role.index')->with(['success' => 'New role is created.']);
    }

    public function edit($id)
    {
        $this->checkPermission('edit role');

        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $old_permissions = $role->permissions->pluck('name')->toArray();
        return view('admin.role.edit', compact('role', 'permissions', 'old_permissions'));
    }

    public function update($id, UpdateRoleRequest $request)
    {
        $this->checkPermission('edit role');

        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->name,
        ]);
        $role->syncPermissions($request->permission);
        return redirect()->route('role.index')->with(['success' => 'That role is updated.']);
    }

    public function destroy($id)
    {
        $this->checkPermission('delete role');

        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json(['message' => 'success'], 200);
    }

    private function checkPermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
