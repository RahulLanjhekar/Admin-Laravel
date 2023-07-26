<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Mail;
use App\Mail\NewMail;
use App\Http\Requests\AdminStoreRequest;
use App\Jobs\SendEmailJob;
use App\Jobs\UpdateMailJob;
use App\Jobs\DeleteMailJob;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function adminHome()
    {
        $tasks = Task::latest()->paginate(8);

        return view('admin.adminHome', ['tasks' => $tasks]);
    }

    public function create(){
        return view('admin.create'); 
    }

    public function store(AdminStoreRequest $request){
        
        $validated = $request->validated();

        $theDate = $request->due_date;

        $carbonDate = Carbon::parse($theDate);
       
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'due_date' => $carbonDate
        ]);
        
        $mailData = [
            'title' => $request->title,
            'body' => $request->description
        ];

        $address = $task->user->email;

        SendEmailJob::dispatch($mailData, $address);

        return back()->withSuccess('Product Created !!');

    }


    public function show($id){

        $task = Task::where('id',$id)->first();
        // dd($task->user->email);

        return view('admin.show', ['task' => $task]);
    }

    public function edit($id){

        $task = Task::where('id',$id)->first();
        
        return view('admin.edit', ['task' => $task]);
    }

    public function delete($id){

        $task = Task::where('id',$id)->first();

        $task->delete();

        $address = $task->user->email;

        $title = $task->title;

        DeleteMailJob::dispatch($title, $address);

        return back()->withSuccess('Product Deleted !!');
    }

    public function update(AdminStoreRequest $request, $id){
        
        $validated = $request->validated();

        
        $theDate = $request->due_date;
        
        $carbonDate = Carbon::parse($theDate);

        $task = Task::where('id',$id)->first();

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'due_date' => $carbonDate
        ]);

        $mailData = [
            'title' => 'Task Updated',
            'body' => 'The task '.($request->title ?? $task->title).' has been updated by the admin.'
        ];

        $address = $task->user->email;

        $id = $task->id;

        // Getting the base url
        $currentUrl = url()->current();
        $defaultUrl = Str::before($currentUrl, '/admin');

        UpdateMailJob::dispatch($mailData, $address, $id, $defaultUrl);

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
