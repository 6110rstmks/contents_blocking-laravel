<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @if ($errors->any())
    <div>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    </div>
    @endif
    <div>
        <div style="font-size: 45px">***{{$cnt}}***</div>
            @foreach($lists as $list)
            <div style="display:flex; font-size: 25px">
                <div>{{$list->name}}</div>
                <div>   {{$list->id}}</div>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>
