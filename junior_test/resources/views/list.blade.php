<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="" method="get">
    @csrf
    @foreach($musics as $music)

        <div class="block">
            <h2>Заголовок: {{$music->title}}</h2>
            <h2>Автор: {{$music->author}}</h2>
            <img style="max-width: 100px" src="{{asset('/storage/'. $music->photo)}}">
        </div>
    @endforeach
</form>
</body>
</html>
