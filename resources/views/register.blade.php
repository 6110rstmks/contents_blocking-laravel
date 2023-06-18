<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h3>Youtube</h3>
<form action="{{ route('register-youtube') }}" method="POST">
    @csrf
    <input type="text" name="channel_name" id="">
    <button>Submit</button>
</form>
<a href="{{ route('Youtube-list') }}">YoutubeBlockChannelList</a>



<h2 style="margin-top: 100px">Word</h2>
<form action="{{ route('register-word') }}" method="POST" >
    @csrf
    <input type="text" name="word_name">
    <button>Submit</button>
</form>
<a href="{{ route('Word-list') }}">WordChannelList</a>


<div style="margin-top:100px">
    <a href="">YoutubeAPI REGISTER</a>
</div>

</body>
</html>