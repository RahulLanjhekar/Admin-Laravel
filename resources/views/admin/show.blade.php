@extends('layouts.app')

@section('content')
<div class="container">
<nav class="navbar top-cont navbar-expand-sm bg-white">

<div class="container-fluid">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="/admin/home">Tasks</a>
    </li>
  </ul>
</div>

</nav>
        <div class="row justify-content-center">
            <div class="col-sm-8 mt-4">
                <div class="view-card card p-4">
                    <p>Title: <b>{{ $task->title }}</b></p>
                    <p>Description: <b>{{ $task->description }}</b></p>
                    <p>Due Date: <b>{{ $task->due_date }}</b></p>
                </div>
            </div>
        </div>
    </div>
@endsection