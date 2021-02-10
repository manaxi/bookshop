<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:User']);
    }

    public function index()
    {
        $user = User::find(auth()->id());
        $user_books = $user->books()->orderBy('created_at', 'desc')->paginate(5);
        return view('dashboard.index', compact('user_books'));
    }
}
