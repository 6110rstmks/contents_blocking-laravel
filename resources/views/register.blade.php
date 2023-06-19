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
<!-- <div>{{$errors->first()}}</div> -->
<div>
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<h3>Youtube</h3>
<form action="{{ route('register-youtube') }}" method="POST">
    @csrf
    <input type="text" name="name" id="">
    <button>Submit</button>
</form>
<a style="font-size: 30px" href="{{ route('Youtube-list') }}">YoutubeBlockChannelList</a>



<h2 style="margin-top: 100px">Word</h2>
<form action="{{ route('register-word') }}" method="POST" >
    @csrf
    <input type="text" name="name">
    <button>Submit</button>
</form>
<a style="font-size: 30px" href="{{ route('Word-list') }}">WordChannelList</a>


<div style="margin-top:100px">
    <h3>YoutubeAPI</h3>
    <form action="{{ route('register-api') }}" method="POST" >
        @csrf
        <input type="text" name="name">
        <button>Submit</button>
    </form>
</div>

</body>
</html>
