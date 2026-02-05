<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ConfirmablePasswordController extends Controller
{
    public function show(): View 
    { 
        abort(404);
    }
    public function store(Request $request): RedirectResponse 
    { 
        return redirect()->intended(route('dashboard')); 
    }
}
