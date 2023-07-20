<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Mail;
use App\Mail\NewMail;
use App\Http\Requests\UserStoreRequest;


class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        // $tasks = $user->is_Admin ? Task::latest()->get() : $user->tasks;
        // dd(Task::where('user_id', $user->id));

        // dd(auth()->user()->email);

        return view('tasks.index', ['tasks' => $user->tasks]);
    }

    public function create(){
        return view('tasks.create'); 
    }

    public function store(UserStoreRequest $request){

        $validated = $request->validated();

        $ticket = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id()
        ]);
        
        $mailData = [
            'title' => $request->title,
            'body' => $request->description
        ];
        
        Mail::to(auth()->user()->email)->send(new NewMail($mailData));
        // dd('Email sent!');
        return back()->withSuccess('Product Created !!');

    }

    public function edit($id){

        $task = Task::where('id',$id)->first();
        
        return view('tasks.edit', ['task' => $task]);
    }

    public function delete($id){

        $task = Task::where('id',$id)->first();

        $task->delete();
        return back()->withSuccess('Product Deleted !!');
    }

    public function show($id){

        $task = Task::where('id',$id)->first();

        return view('tasks.show', ['task' => $task]);
    }

    public function update(UserStoreRequest $request, $id){
        
        $validated = $request->validated();

        $task = Task::where('id',$id)->first();

        $task->title = $request->title;
        $task->description = $request->description;
        // $task->due_date = $request->due_date;

        $task->save();

        return back()->withSuccess('Product Updated !!');
    }

    public function search(Request $request){

        $search = $request->search;

        $tasks = Task::sortable()->where(function($query) use ($search){

            $query->where('title','like',"%$search%")
            ->orWhere('description','like',"%%$search");

        })->paginate(4);

        // dd($tasks);

        return view('tasks.index',compact('tasks','search'));
    }
    
}
