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
    <input name="curl" type="text" placeholder="Введите ссылку">
    <button type="submit">Найти звук</button>
</form>
</body>
</html>
