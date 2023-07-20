<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Mail;
use App\Mail\NewMail;
use App\Http\Requests\AdminStoreRequest;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function adminHome()
    {
        $tasks = Task::latest()->sortable()->paginate(4);
        return view('admin.adminHome', ['tasks' => $tasks]);
    }

    public function create(){
        return view('admin.create'); 
    }

    public function store(AdminStoreRequest $request){
        
        $validated = $request->validated();

        $ticket = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id,
        ]);

        $mailData = [
            'title' => $request->title,
            'body' => $request->description
        ];

        Mail::to('rahul@zethic.com')->send(new NewMail($mailData));
        return back()->withSuccess('Product Created !!');

    }


    public function show($id){

        $task = Task::where('id',$id)->first();

        return view('admin.show', ['task' => $task]);
    }

    public function edit($id){

        $task = Task::where('id',$id)->first();
        
        return view('admin.edit', ['task' => $task]);
    }

    public function delete($id){

        $task = Task::where('id',$id)->first();

        $task->delete();
        return back()->withSuccess('Product Deleted !!');
    }

    public function update(AdminStoreRequest $request, $id){
        
        $validated = $request->validated();

        $task = Task::where('id',$id)->first();

        $task->title = $request->title;
        $task->description = $request->description;
        $task->user_id = $request->user_id;
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

        return view('admin.adminHome',compact('tasks','search'));
    }
}
