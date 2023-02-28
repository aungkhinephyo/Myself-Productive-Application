<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;

class AdminProfileController extends Controller
{
    public function profile()
    {
        $this->checkPermission('view my profile');
        $user = User::findOrFail(auth()->id());
        return view('admin.profile.profile', compact('user'));
    }

    public function changePassword()
    {
        $this->checkPermission('change my password');
        return view('admin.profile.change_password');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $this->checkPermission('change my password');

        $user = User::findOrFail(auth()->id());
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);
        return redirect()->route('admin.admin_panel');
    }

    public function editProfile()
    {
        $this->checkPermission('edit my profile');

        $user = User::findOrFail(auth()->id());
        return view('admin.profile.edit_profile', compact('user'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $this->checkPermission('edit my profile');

        $user = User::findOrFail(auth()->id());

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
            'twitter' => $request->twitter,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'profile_img' => $profile_img,
        ]);
        return redirect()->route('admin.profile')->with(['success' => 'Your profile is updated.']);
    }

    private function checkPermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
