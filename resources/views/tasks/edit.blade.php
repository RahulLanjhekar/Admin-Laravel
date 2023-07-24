<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<nav class="navbar navbar-style navbar-expand-sm">

<div class="container-fluid">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="/home">< Tasks</a>
    </li>
  </ul>
</div>

</nav>

    @if($message = Session::get('success'))
      <div class="alert alert-success alert-block">
        <strong>{{$message}}</strong>
      </div>
    @endif
    <div class="container mt-4">
    <h1 class='create-head'>Edit Task:- {{ $task->title }}</h1>
       <div class="row justify-content-center">
        <div class="col-sm-8">
          <div class="card form-style mt-3 p-3">
          <form method="POST" action='/tasks/{{$task->id}}/update'>
            @csrf
            @method('PUT')
            <div class="form-group">
              <label>Title</label>
              <input type="text" name='title' value="{{ old('title',$task->title) }}" class='form-control'>
              @if($errors->has('title'))
                <span class='text-danger'>{{ $errors->first('title')}}</span>
              @endif  
            </div>
            <div class="form-group">
              <label>Description</label>
              <textarea name='description' class='form-control' rows='4'>{{ old('description',$task->description) }}</textarea>
              @if($errors->has('description'))
                <span class='text-danger'>{{ $errors->first('description')}}</span>
              @endif  
            </div>
            <div class="form-group">
              <label>Due Date</label>
              <input type="text" name='due_date' value="{{ old('due_date',$task->due_date) }}" class='form-control'>        
              @if($errors->has('due_date'))
                <span class='text-danger'>{{ $errors->first('due_date')}}</span>
              @endif      
            </div>
            <button class='mt-2 btn btn-dark' type='submit'>Edit</button>
          </form>
          </div>
        </div>
       </div>
    </div>
</body>
</html>