<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @foreach($word_blackList as $word_name)
        <div>{{$word_name->name}}</div>
    @endforeach


    <a href="{{route('Youtube-list')}}">To YoutubeList</a>

    <form action="{{route('testest')}}" method="POST">
        <button>sousin</button>
    </form>


    <a href="{{route('word-download')}}" style="display: block; margin-top:300px; color: red;">CSV import</a>
</body>
</html>
