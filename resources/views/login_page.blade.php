<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <input type="text" name="email">
        <input type="password" name="password">
        <button>submit</button>
    </form>

    @if (!auth()->check())
    <div>mada</div>
    @endif


</body>
</html>
