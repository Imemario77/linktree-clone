<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        $user->load(['links', 'shortUrls']);

        return view('dashboard.index', [
            'user' => $user,
            'links' => $user->links()->orderBy('created_at', 'desc')->get(),
            'shortUrls' => $user->shortUrls()->orderBy('created_at', 'desc')->get()
        ]);
    }
}