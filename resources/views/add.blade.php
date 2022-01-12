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
<form enctype="multipart/form-data" method="post">
    @csrf
    <input name="title" type="text" placeholder="title">
    <input name="author" type="text" placeholder="author">
    <input name="album" type="text" placeholder="album">
    <input name="url" type="text" placeholder="url">
    <input name="photo" type="file" placeholder="photo">
    <button type="submit">Отправить</button>
</form>
</body>
</html>
