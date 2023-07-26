<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Http\Requests\UserStoreRequest;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Jobs\AdminUpdateJob;

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

        return view('tasks.index', ['tasks' => $user->tasks]);
    }

    public function create(){
        return view('tasks.create'); 
    }

    public function store(UserStoreRequest $request){

        $validated = $request->validated();

        $theDate = $request->due_date;

        $carbonDate = Carbon::parse($theDate);

        $ticket = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(),
            'due_date' => $carbonDate
        ]);
        
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

        $theDate = $request->due_date;

        $carbonDate = Carbon::parse($theDate);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $carbonDate
        ]);

        // Finding admins
        $users = User::where('type', 1);
        $emails = $users->pluck('email')->toArray();

        $id = $task->id;

        // Getting the base url
        $currentUrl = url()->current();
        $defaultUrl = Str::before($currentUrl, '/tasks');

        AdminUpdateJob::dispatch($emails, $id, $defaultUrl);

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
