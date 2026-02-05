<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class NewPasswordController extends Controller
{
    public function create(Request $request): View 
    { 
        // return view('auth.reset-password'); 
        abort(404);
    }
    
    public function store(Request $request): RedirectResponse 
    { 
        return redirect()->route('login'); 
    }
}
