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
<form action="getMusic" enctype="multipart/form-data" method="post">
    @csrf
    <input name="url" type="text" placeholder="Введите ссылку">
{{--    <a href="{{"/music/"}}" type="submit">Найти звук</a>--}}
    <button onclick="drawShelves(); return false;">add</button>
    <button>Send</button>
</form>
</body>
</html>
