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
    <div style="display:flex">

        <div style="flex: 50%;">
            <div style="font-size: 45px">***{{$cnt}}***</div>
            @foreach($lists as $name)
            <div style="display:flex; font-size: 25px">
                <div>{{$name->name}}</div>
                @if ($filename === "word")
                    @if ($name->disableFlg === 0)
                        <form action="{{route('word-unblock', $name)}}" style="margin-left: 15px" method="POST">
                        @csrf
                            <button style="font-size: 25px">unblock</button>
                        </form>
                    @elseif ($name->disableFlg == 1)
                        <span style="font-size: 25px; border: 1px black solid; margin-left: 15px">Now enable</span>
                    @endif
                @endif
            </div>
            @endforeach
        </div>

        <div>
            <a href="{{$export}}" style=margin-top:300px; color: red;">CSV Export</a>

            <form action="{{$import}}" style="margin-top: 100px" method="POST" enctype="multipart/form-data">
                @csrf
                <p class="mt-5"><input type="file" name="txtFile"></p>
                <button>CSV import</button>
            </form>
        </div>
    </div>



</body>
</html>
