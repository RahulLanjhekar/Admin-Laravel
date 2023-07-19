<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function adminHome()
    {
        $tasks = Task::latest()->get();
        return view('adminHome', ['tasks' => $tasks]);
    }
}
