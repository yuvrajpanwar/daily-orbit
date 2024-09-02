<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
</head>
<body>
    @if (session('success'))
    <div class="alert alert-success show col-lg-7" id="alert-success">
        <a data-toggle="collapse" href="#alert-success" role="button" aria-expanded="true"
            aria-controls="alert-success" class="btn-link close-button">X</a>
        {{ session('success') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{route('admin.login')}}" method="POST">
        @csrf
        <input type="text" placeholder="email" name="email">
        <input type="text" placeholder="password" name="password">
        <input type="submit" value="submit">
    </form>
</body>
</html>