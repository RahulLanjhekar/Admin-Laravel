@extends('layouts.app')
    
@section('content')
<div class="container main-container bg-white">
    <div class='search-div'>
        <div class="row py-2"></div>
        <div class="col-md-6">
            <a href="/admin/create" class='btn btn-dark mt-2 top-btns'>New Task</a>
        </div>

        <div class="col-md-6 mb-2">
            <div class="form-group">
                <form action="/admin/search" method='get'>
                    <div class="input-group flex">
                        <input type="text" class='form-control' name='search' placeholder='Search...' value="{{ isset($search) ? $search : '' }}">
                        <button type='submit' class='btn btn-primary top-btns'> Search</button>
                    </div>
                </form>
            </div>
        </div>
        </div>

        <!-- @if(isset($search) && $search !== 'null')
        {{collect($tasks)->where('title','like',"%$search%") }}
        @endif  -->

            <div class="wrapping flex flex-wrap">
                @foreach($tasks as $task)
           
                    <div class="card-container">
                        <div class="inside-card">
                            <h2>Id:- {{ $task->id}}</h2>
                        </div>

                        <div class="inside-card">
                            <h2>Title</h2>
                            <h2><a href="/admin/{{$task->id}}/show" class='text-dark'>{{ $task->title}}</a></h2>
                        </div>

                        <div class="inside-card">
                            <h2>Description</h2>
                            <h2>{{ $task->description}}</h2>
                        </div>

                        <div class="inside-card">
                            <h3>Due Date:- {{ $task->due_date ?? 'null'}}</h3>
                        </div>

                        <div class="action-card">
                            <a href="/admin/{{$task->id}}/edit" class='btn action-btns btn-dark btn-sm'>Edit</a>
                            <form method='POST' action="/admin/{{$task->id}}/delete" class='d-inline'>
                                @csrf
                                @method('DELETE')
                                <button type='submit' class='btn btn-danger action-btns btn-sm'>Delete</button>
                            </form>
                        </div>
                </div>
                @endforeach
            </div>
      
       {{-- <!-- {{dd($search)}} -->--}}
       <!-- {!! $tasks->appends(Request::except('page'))->render() !!} -->
       {!! $tasks->appends(\Request::except('page'))->render() !!}
      
    </div>
@endsection