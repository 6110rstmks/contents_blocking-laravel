<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<div style="font-size: 24px;">Left Time for disabling BlockingWord:<span style="color: red">{{$diffTime}}</span></div>
@if ($errors->any())
    <div>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    </div>
    @endif
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
        <div>You can disable the belows at any time. 15分経つと自動で戻る</div>
        @foreach ($lists3 as $name)
        <div style="display:flex; font-size: 25px">
            <div>{{$name->name}}</div>
            @if ($name->disableFlg === 0)
                <form action="{{route('word-unblock', $name)}}" style="margin-left: 15px" method="POST">
                @csrf
                    <button style="font-size: 25px">15分解除</button>
                </form>
            @elseif ($name->disableFlg == 1)
                <span style="font-size: 25px; border: 1px black solid; margin-left: 15px">Now enable</span>
            @endif
        </div>
        @endforeach
    </section>
</div>


<section class="first" style="font-size: 40px; margin-top: 100px; border: 1px green solid">
    <span>You can't disable </span>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
    </a>
    <div style="margin-top: 15px; display: none" id="myLinks">
        @foreach ($lists1 as $name)
        <div style="font-size: 25px">
            <div>{{$name->name}}</div>
        </div>
        @endforeach
    </div>
</section>

<script>
const myFunction = () => {
  let x = document.getElementById("myLinks");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
</script>
