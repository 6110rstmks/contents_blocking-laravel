<div style="font-size: 24px;">Left Time for disabling BlockingWord:<span style="color: red">{{$diffTime}}</span></div>

<div style="display: flex; margin-top: 100px">

    <section class="second" style="flex: 50%">
    <div>解除可</div>
        @foreach ($lists2 as $name)
        <div style="display:flex; font-size: 25px">
            <div>{{$name->name}}</div>
            @if ($name->disableFlg === 0)
                <form action="{{route('word-unblock', $name)}}" style="margin-left: 15px" method="POST">
                @csrf
                    <button style="font-size: 25px">unblock</button>
                </form>
            @elseif ($name->disableFlg == 1)
                <span style="font-size: 25px; border: 1px black solid; margin-left: 15px">Now enable</span>
            @endif
        </div>
        @endforeach
    </section>
    <section class="third">
        <div>いつでも解除可 15分経つと自動で戻る</div>
        @foreach ($lists3 as $name)
        <div style="display:flex; font-size: 25px">
            <div>{{$name->name}}</div>
            @if ($name->disableFlg === 0)
                <form action="{{route('word-unblock', $name)}}" style="margin-left: 15px" method="POST">
                @csrf
                    <button style="font-size: 25px">unblock</button>
                </form>
            @elseif ($name->disableFlg == 1)
                <span style="font-size: 25px; border: 1px black solid; margin-left: 15px">Now enable</span>
            @endif
        </div>
        @endforeach
    </section>
</div>


<section class="first" style="margin-top: 100px; border: 1px green solid">
    <div>解除不可</div>
    <div style="margin-top: 15px">
        @foreach ($lists1 as $name)
        <div style="display:flex; font-size: 25px">
            <div>{{$name->name}}</div>
        </div>
        @endforeach
    </div>
</section>
