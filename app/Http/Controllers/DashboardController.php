<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function goTo()
    {
        if (auth()->user()->hasRole(['super admin', 'admin'])) {
            return redirect()->route('admin.admin_panel');
        }
        if (auth()->user()->hasRole('user')) {
            return redirect()->route('user.home');
        }
    }
}
