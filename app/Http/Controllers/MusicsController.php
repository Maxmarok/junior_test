<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Musics;
use Illuminate\Support\Facades\Storage;

class MusicsController extends Controller
{
    public function curlGet(Request $request)
    {
        // ссылка и параметры для curl
        $url = 'https://parser.peak.promo';
        $params = [
            'action' => 'getMusic',
            'url' => $request->url,
        ];

        // curl запрос в тикток по url с параметрами
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // возврат в виде массива
        return json_decode($response, true);
    }

    public function getMusic(Request $request)
    {
        // поиск трека в тикток
        $response = $this->curlGet($request);

        // запись url в сессию
        $request->session()->put('url', $request->url);

        return $response;
    }

    public function addMusic(Request $request)
    {
        // получение актуальных данных с тиктока
        $response = $this->curlGet($request);

        // данные из формы
        $title = trim($request->title);
        $author = trim($request->author);
        $album = trim($request->album);

        // ссылка на аватар
        $imageUrl = $response['music']['coverLarge'];

        // извлекаем расширение файла по ссылке из curl и обрезаем лишнее
        $extension = new \SplFileInfo($imageUrl);

        if (stripos($extension, '?')) {
            $extension = stristr($extension->getExtension(), '?', true);
        } else {
            $extension = $extension->getExtension();
        }

        // генерируем уникальное имя во избежание возможного конфликта уже существующих
        // и склеиваем имя и расширение
        $image = microtime(true) . '.' . $extension;

        // загружаем изображение с новым именем в каталог storage/app/public/avatar
        Storage::disk('public')->put("avatar/{$image}", file_get_contents($imageUrl));

        // если форма не заполнена, берем данные из тиктока
        if ($title == '') $title = $response['music']['title'];
        if ($author == '') $author = $response['music']['authorName'];
        if ($album == '') $album = $response['music']['album'];

        // запись в БД
        Musics::create([
            'title'     => $title,
            'author'    => $author,
            'album'     => $album,
            'image'     => Storage::url("avatar/{$image}"),
            'url'       => $request->session()->get('url'),
        ]);

        // удаление сессии с url
        $request->session()->forget('url');
    }

    public function music_list()
    {
        return Musics::get();
    }
}
