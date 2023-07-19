@extends('layouts.app')

@section('content')
<div class="container bg-white">
        <div class="row py-2"></div>
        <div class="col-md-6">
            <a href="tasks/create" class='btn btn-dark mt-2'>New Task</a>
        </div>

        <div class="col-md-6 mt-4 mb-2">
            <div class="form-group">
                <form action="/tasks/search" method='get'>
                    <div class="input-group">
                        <input type="text" class='form-control' name='search' placeholder='Search...' value="{{ isset($search) ? $search : '' }}">
                        <button type='submit' class='btn btn-primary'> Search</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- @if(isset($search) && $search !== 'null')
        {{collect($tasks)->where('title','like',"%$search%") }}
        @endif  -->

        <table class='table table-hover mt-2'>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr>
                    <!-- <td>{{ $loop->index + 1}}</td> -->
                    <td>{{ $task->id}}</td>
                    <td><a href="/tasks/{{$task->id}}/show" class='text-dark'>{{ $task->title}}</a></td>
                    <td>{{ $task->description}}</td>
                    <td><a href="/tasks/{{$task->id}}/edit" class='btn btn-dark btn-sm'>Edit</a>
                    <form method='POST' action="/tasks/{{$task->id}}/delete" class='d-inline'>
                        @csrf
                        @method('DELETE')
                        <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                    </form>
                </td>
                </tr>
                @endforeach
            </tbody>

        </table>
       {{-- <!-- {{dd($search)}} -->--}}
      
    </div>
@endsection
