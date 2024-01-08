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

<div style="margin: 0 auto; width: 60%">
    <section class="youtube-channel">
        <div style="display:flex">
            <div>
                <h1>Youtube</h1>
                <form action="{{ route('register-youtube') }}" method="POST">
                    @csrf
                    <input type="text" name="name" id="">
                    <button class="test">Submit</button>
                </form>
                <a style="font-size: 30px" href="{{ route('Youtube-list') }}">YoutubeBlockChannelList</a>
            </div>
            <div style="margin-left: 30px">
                <a href="{{route('youtube-download')}}" style="margin-top:300px; color: red;">CSV Export</a>

                <form action="{{route('youtube-csv-import')}}" style="margin-top: 100px" method="POST" enctype="multipart/form-data">
                    @csrf
                    <p class="mt-5"><input type="file" name="txtFile"></p>
                    <button>CSV import</button>
                </form>
            </div>
        </div>
    </section>

    <!-- word -->
    <section class="word" style="margin-top: 100px">
        <div style="display:flex">
            <div>
                <h2>Word</h2>
                <p>日本語を登録する際、4文字以上の単語はひらがなではなくカタカナで登録してください</p>
                <form action="{{ route('register-word') }}" method="POST" >
                    @csrf
                    <input type="text" name="name">
                    <div>
                        <label for="">解除不可</label>
                        <input type="radio" name="genre" value="1">
                    </div>
                    <div>
                        <label for="">解除可</label>
                        <input type="radio" name="genre" value="2">
                    </div>
                    <div>
                        <label for="">いつでも解除可</label>
                        <input type="radio" name="genre" value="3">
                    </div>
                    <div>
                        <button>Submit</button>
                    </div>
                </form>
                <a style="font-size: 30px" href="{{ route('Word-list') }}">WordChannelList</a>
            </div>
            <div style="margin-left: 30px">
                <a href="{{route('word-download')}}" style="margin-top:300px; color: red;">CSV Export</a>

                <form action="{{route('word-csv-import')}}" style="margin-top: 100px" method="POST" enctype="multipart/form-data">
                    @csrf
                    <p class="mt-5"><input type="file" name="txtFile"></p>
                    <button>CSV import</button>
                </form>
            </div>
        </div>
    </section>

    <section class="site">
        <h2 style="margin-top: 100px">Site</h2>
        <div style="display:flex">
            <div>
                <form action="{{ route('register-site') }}" method="POST" >
                    @csrf
                    <input type="text" name="name">
                    <button>Submit</button>
                </form>
                <a style="font-size: 30px" href="{{ route('Site-list') }}">SiteList</a>
            </div>
            <div style="margin-left: 30px">
                <a href="{{route('site-download')}}" style="margin-top:300px; color: red;">CSV Export</a>
                <a href="{{route('site_for_hosts-download')}}" style="margin-top:300px; color: red;">CSV Export</a>

                <form action="{{route('site-csv-import')}}" style="margin-top: 100px" method="POST" enctype="multipart/form-data">
                    @csrf
                    <p class="mt-5"><input type="file" name="txtFile"></p>
                    <button>CSV import</button>
                </form>
            </div>
        </div>
    </section>



    @if (App\Models\YoutubeApi::all()->count() == 0)
    <div style="margin-top:100px">
        <h3>YoutubeAPI</h3>
        <h4>keepにほかんしてる</h4>
        <form action="{{route('register-api')}}" method="POST" >
            @csrf
            <input type="text" name="name">
            <button>Submit</button>
        </form>
    </div>
    @else
    <div style="margin-top : 60px">Youtube Api is already registered.</div>
    @endif

    <section style="margin-top: 100px">
        <h2>Sign up</h2>
        <form action="{{ route('register-user') }}" method="POST">
            @csrf
            <div>Email</div>
            <input type="email" name="email">
            <span>PASSWORD</span>
            <input type="password" name="password">
            <button>Submit</button>
        </form>
    </section>
</div>

</body>
</html>
