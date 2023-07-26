<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
    <style>
        .top-btns{
            padding: 7px 10px !important;
            font-size: 15px;
            color: #FFDBAA !important;
            text-decoration: none !important;
            display: block;
            width: 100px !important;
            text-align: center !important;
            margin: 10px 20px;
            border-radius: 5px;
            background-color: #4682A9  !important;
            border: none;
        }
    </style>
</head>
<body>
    This task has been updated by the Admin.

    <a href="{{ $defaultUrl }}/tasks/{{ $id }}/show" class='btn btn-dark top-btns'>Task</a>

</body>
</html> 