<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="{{ route('register') }}" method="POST">
    @csrf
    <input type="text" name="channel_name" id="">
    <button>Submit</button>
</form>
</body>
</html>