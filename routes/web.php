<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\NoteController;
use App\Http\Controllers\User\TaskController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\EventController;

use App\Http\Controllers\User\JournalController;

use App\Http\Controllers\User\LibraryController;
use App\Http\Controllers\User\ProjectController;
use App\Http\Controllers\User\TodolistController;
use App\Http\Controllers\User\UserPageController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\Admin\LibraryTypeController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\TodolistTypeController;

Route::redirect('/', 'login');

// Route::get('assign',function(){
//     for ($i=35; $i < 50; $i++) {
//        $user = User::findOrFail($i);
//         $user->syncRoles('user');
//     }
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    /* go to admin or user Dashboard */
    Route::get('dashboard', [DashboardController::class, 'goTo']);

    Route::group(['prefix' => 'admin', 'middleware' => 'admin_middleware'], function () {
        /* admin panel */
        Route::get('panel', [AdminPageController::class, 'adminPanel'])->name('admin.admin_panel');

        /* admin profile */
        Route::get('profile', [AdminProfileController::class, 'profile'])->name('admin.profile');
        Route::get('profile/change_password', [AdminProfileController::class, 'changePassword'])->name('admin.change_password');
        Route::post('profile/update_password', [AdminProfileController::class, 'updatePassword'])->name('admin.update_password');
        Route::get('profile/edit_profile', [AdminProfileController::class, 'editProfile'])->name('admin.edit_profile');
        Route::post('profile/update_profile', [AdminProfileController::class, 'updateProfile'])->name('admin.update_profile');

        /* user trash */
        Route::get('user/trash', [UserController::class, 'trash'])->name('user_list.trash');
        Route::get('user/trash/data', [UserController::class, 'trashData']);
        Route::post('user/{id}/restore', [UserController::class, 'restore']);
        Route::post('user/{id}/force_delete', [UserController::class, 'forceDelete']);
        /* user list */
        Route::get('user/datatable/ssd', [UserController::class, 'ssd']);
        Route::resource('user', UserController::class);

        /* role */
        Route::get('role/datatable/ssd', [RoleController::class, 'ssd']);
        Route::resource('role', RoleController::class)->except(['show']);

        /* permission */
        Route::get('permission/datatable/ssd', [PermissionController::class, 'ssd']);
        Route::resource('permission', PermissionController::class)->except(['show']);

        /* todolist type */
        Route::get('todolist_type/datatable/ssd', [TodolistTypeController::class, 'ssd']);
        Route::resource('todolist_type', TodolistTypeController::class)->except(['show']);

        /* library type */
        Route::get('library_type/datatable/ssd', [LibraryTypeController::class, 'ssd']);
        Route::resource('library_type', LibraryTypeController::class)->except(['show']);
    });

    /* ----------------------------- End Admin --------------------------------------- */

    /* ----------------------------- Start User --------------------------------------- */
    Route::group(['middleware' => 'user_middleware'], function () {

        /* user dashboard */
        Route::get('myself', [UserPageController::class, 'home'])->name('user.home');
        Route::get('contact', [UserPageController::class, 'contact'])->name('user.contact');

        /* user Profile */
        Route::get('profile', [UserProfileController::class, 'profile'])->name('user.profile');
        Route::post('profile/update_profile', [UserProfileController::class, 'updateProfile'])->name('user.update_profile');
        Route::get('setting/change_password', [UserProfileController::class, 'changePassword'])->name('user.change_password');
        Route::post('setting/update_password', [UserProfileController::class, 'updatePassword'])->name('user.update_password');

        /* Notes */
        Route::get('note/ssd', [NoteController::class, 'ssd']);
        Route::resource('note', NoteController::class)->except(['edit']);

        /* Events */
        Route::resource('event', EventController::class)->except(['show', 'create', 'edit']);

        /* Journal */
        Route::get('journal/datatable/ssd', [JournalController::class, 'ssd']);
        Route::resource('journal', JournalController::class);

        /* Project */
        Route::get('project/datatable/ssd', [ProjectController::class, 'ssd']);
        Route::resource('project', ProjectController::class);

        /* Tasks (For Project) */
        Route::get('task/data', [TaskController::class, 'taskData']);
        Route::post('task/draggable', [TaskController::class, 'taskDraggable']);
        Route::resource('task', TaskController::class)->only(['store', 'update', 'destroy']);

        /* Library */
        Route::get('library/datatable/ssd', [LibraryController::class, 'ssd']);
        Route::resource('library', LibraryController::class)->except(['show']);

        /* Todolist */
        Route::get('todolist/data', [TodolistController::class, 'todolistData']);
        Route::get('todolist/history', [TodolistController::class, 'todolistHistory'])->name('todolist.history');
        Route::get('todolist/history/data', [TodolistController::class, 'todolistHistoryData']);
        Route::resource('todolist', TodolistController::class)->except(['show', 'create', 'edit']);
    });
});
