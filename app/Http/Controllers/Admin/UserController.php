<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        $this->checkPermission('view user');
        return view('admin.users.index');
    }

    public function show($id)
    {
        $this->checkPermission('view user');
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function ssd(Request $request)
    {
        $this->checkPermission('view user');

        $users = User::with('roles');
        if (auth()->user()->hasRole('admin')) {
            $users = User::role('user');
        }
        return Datatables::of($users)
            ->filterColumn('role', function ($query, $keyword) {
                $query->whereHas('roles', function ($q1) use ($keyword) {
                    $q1->where('name', 'like', "%$keyword%");
                });
            })
            ->addColumn('plus_icon', function ($each) {
                return null;
            })
            ->editColumn('name', function ($each) {
                $name = '';
                if ($each->hasRole(['admin', 'super admin'])) {
                    $name = '<span class="text-danger text-capitalize fw-bold">' . $each->name . '</span>';
                } else {
                    $name = '<span class="text-capitalize">' . $each->name . '</span>';
                }
                return $name;
            })
            ->editColumn('job', function ($each) {
                return $each->job ? $each->job : '-';
            })
            ->editColumn('role', function ($each) {
                return $each->getRoleNames()[0];
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $info_icon = '';
                $delete_icon = '';
                if (auth()->user()->can('view user')) {
                    $info_icon = '<a href="' . route('user.show', $each->id) . '" class="text-primary"><i class="bi bi-info-circle-fill"></i></a>';
                }
                if (auth()->user()->can('edit user')) {
                    $edit_icon = '<a href="' . route('user.edit', $each->id) . '"><i class="bi bi-pencil-square"></i></a>';
                }
                if (auth()->user()->can('delete user')) {
                    $delete_icon = '<a href="javascript:void(0);" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bi bi-trash"></i></a>';
                }

                return '<div class="action-icons">' . $edit_icon . $info_icon . $delete_icon . '</div>';
            })
            ->rawColumns(['name', 'action'])
            ->make(true);
    }

    public function create()
    {
        $this->checkPermission('create user');
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $this->checkPermission('create user');

        $profile_img = null;
        if ($request->hasFile('profile_img')) {
            $img_file = $request->file('profile_img');
            $img_name = uniqid() . '_' . $img_file->getClientOriginalName();
            Storage::disk('public')->put('profile_images/' . $img_name, file_get_contents($img_file));
            $profile_img = $img_name;
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'job' => $request->job,
            'about' => $request->about,
            'password' => Hash::make($request->password),
            'twitter' => $request->twitter,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'profile_img' => $profile_img,
        ]);
        $user->markEmailAsVerified();
        $user->syncRoles($request->role);
        return redirect()->route('user.index')->with(['success' => 'New user is created.']);
    }

    public function edit($id)
    {
        $this->checkPermission('edit user');

        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update($id, UpdateUserRequest $request)
    {
        $this->checkPermission('edit user');

        $user = User::findOrFail($id);
        $profile_img = $user->profile_img;

        if ($request->hasFile('profile_img')) {
            Storage::disk('public')->delete('profile_images/' . $user->profile_img);

            $img_file = $request->file('profile_img');
            $img_name = uniqid() . '_' . $img_file->getClientOriginalName();
            Storage::disk('public')->put('profile_images/' . $img_name, file_get_contents($img_file));
            $profile_img = $img_name;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'job' => $request->job,
            'about' => $request->about,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'twitter' => $request->twitter,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'profile_img' => $profile_img,
        ]);
        $user->syncRoles($request->role);
        return redirect()->route('user.index')->with(['success' => 'That user is updated.']);
    }

    public function destroy($id)
    {
        $this->checkPermission('delete user');
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'success'], 200);
    }

    public function trash()
    {
        $this->checkPermission('restore user');

        return view('admin.users.trash');
    }

    public function trashData()
    {
        $this->checkPermission('restore user');

        $users = User::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('admin.components.trash_table', compact('users'))->render();
    }

    public function restore($id)
    {
        $this->checkPermission('restore user');

        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        return response()->json(['message' => 'success'], 200);
    }

    public function forceDelete($id)
    {
        $this->checkPermission('forceDelete user');

        $user = User::onlyTrashed()->findOrFail($id);
        Storage::disk('public')->delete('profile_images/' . $user->profile_img);
        $user->forceDelete();
        return response()->json(['message' => 'success'], 200);
    }

    private function checkPermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
