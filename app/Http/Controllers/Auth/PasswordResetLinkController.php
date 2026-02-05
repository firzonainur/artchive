<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PasswordResetLinkController extends Controller
{
    public function create(): View 
    { 
        // return view('auth.forgot-password'); 
        abort(404, 'Not Implemented yet');
    }

    public function store(Request $request): RedirectResponse 
    { 
        return back()->with('status', 'We have emailed your password reset link!'); 
    }
}
