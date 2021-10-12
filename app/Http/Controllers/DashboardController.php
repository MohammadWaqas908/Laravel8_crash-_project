<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Mail\Postliked;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        // $user = auth()->user();
        // Mail::to($user)->send(new Postliked());
        return view('dashboard');
    }
}
