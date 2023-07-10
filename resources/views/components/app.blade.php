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
        <a href="{{$export}}" style="margin-top:300px; color: red;">CSV Export</a>

        <form action="{{$import}}" style="margin-top: 100px" method="POST" enctype="multipart/form-data">
            @csrf
            <p class="mt-5"><input type="file" name="txtFile"></p>
            <button>CSV import</button>
        </form>
    </div>
    <div>
        <div style="font-size: 45px">***{{$cnt}}***</div>
        @if ($filename === "word")
            <div style="display: flex">
                @foreach($lists as $name)
                <section class="first">
                    <div style="display:flex; font-size: 25px">
                        @if ($name->genre === 1)

                            <div>{{$name->name}}</div>
                        @endif
                        @if ($name->disableFlg === 0)
                            <form action="{{route('word-unblock', $name)}}" style="margin-left: 15px" method="POST">
                            @csrf
                                <button style="font-size: 25px">unblock</button>
                            </form>
                        @elseif ($name->disableFlg == 1)
                            <span style="font-size: 25px; border: 1px black solid; margin-left: 15px">Now enable</span>
                        @endif
                    </div>
                </section>
                <section class="second">
                    <div style="display:flex; font-size: 25px">
                        @if ($name->genre === 2)
                            <div>{{$name->name}}</div>
                        @endif
                        @if ($name->disableFlg === 0)
                            <form action="{{route('word-unblock', $name)}}" style="margin-left: 15px" method="POST">
                            @csrf
                                <button style="font-size: 25px">unblock</button>
                            </form>
                        @elseif ($name->disableFlg == 1)
                            <span style="font-size: 25px; border: 1px black solid; margin-left: 15px">Now enable</span>
                        @endif
                    </div>
                </section>
                <section class="third">
                    <div style="display:flex; font-size: 25px">
                        @if ($name->genre === 3)
                            <div>{{$name->name}}</div>
                        @endif
                        @if ($name->disableFlg === 0)
                            <form action="{{route('word-unblock', $name)}}" style="margin-left: 15px" method="POST">
                            @csrf
                                <button style="font-size: 25px">unblock</button>
                            </form>
                        @elseif ($name->disableFlg == 1)
                            <span style="font-size: 25px; border: 1px black solid; margin-left: 15px">Now enable</span>
                        @endif
                    </div>
                </section>
                @endforeach
            </div>
        @else
            @foreach($lists as $name)
            <div style="display:flex; font-size: 25px">
                <div>{{$name->name}}</div>
            </div>
            @endforeach
        @endif
    </div>
</body>
</html>
