<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
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

<h3>Youtube</h3>
<form action="{{ route('register-youtube') }}" method="POST">
    @csrf
    <input type="text" name="name" id="">
    <button class="test">Submit</button>
</form>
<a style="font-size: 30px" href="{{ route('Youtube-list') }}">YoutubeBlockChannelList</a>


<h2 style="margin-top: 100px">Word</h2>
<form action="{{ route('register-word') }}" method="POST" >
    @csrf
    <input type="text" name="name">
    <button>Submit</button>
</form>
<a style="font-size: 30px" href="{{ route('Word-list') }}">WordChannelList</a>

<h2 style="margin-top: 100px">Site</h2>
<form action="{{ route('register-site') }}" method="POST" >
    @csrf
    <input type="text" name="name">
    <button>Submit</button>
</form>
<a style="font-size: 30px" href="{{ route('Site-list') }}">SiteList</a>


@if (App\Models\YoutubeApi::all()->count() == 0)
<div style="margin-top:100px">
    <h3>YoutubeAPI</h3>
    <form action="{{ route('register-api') }}" method="POST" >
        @csrf
        <input type="text" name="name">
        <button>Submit</button>
    </form>
</div>
@else
<div style="margin-top : 60px">Youtube Api is already registered.</div>
@endif

</body>
</html>
