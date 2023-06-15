<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @foreach($youtube_blackList as $channel_name)
        <div>{{$channel_name->name}}</div>
    @endforeach


    <a href="{{route('download')}}" style="display: block; margin-top:300px; color: red;">CSV import</a>
</body>
</html>
