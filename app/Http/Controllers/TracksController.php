<?php

namespace App\Http\Controllers;

use App\Models\Tracks;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Image;
use Symfony\Component\HttpFoundation\File\File;


class TracksController extends Controller
{

    const URL_GET_MUSIC = 'https://parser.peak.promo/';

    public function getTracksList()
    {
        return response()->json(Tracks::all());
    }

    public function addTrack(Request $request)
    {
        $urlImage = $request->image;
        $content  = file_get_contents($urlImage);
        $path     = 'public/images/' . md5(microtime() . rand(0, 9999)) . '.jpg';
        Storage::put($path, $content);

        $track         = new Tracks();
        $track->title  = $request->title;
        $track->author = $request->author;
        $track->album  = $request->album;
        $track->image  = Storage::url($path);
        $track->url    = $request->url;

        if ($track->save()) {
            return response()->json(['data' => 'Данные добавлены'], 201);
        } else {
            return response()->json(['data' => 'Ошибка'], 400);
        }
    }

    private function curl_post(array $post = null, array $options = [])
    {
        $defaults = [
            CURLOPT_POST           => 1,
            CURLOPT_HEADER         => 0,
            CURLOPT_URL            => self::URL_GET_MUSIC,
            CURLOPT_FRESH_CONNECT  => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE   => 1,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_POSTFIELDS     => http_build_query($post),
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options + $defaults);
        if (!$res = curl_exec($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $res;
    }

    public function getMusic(Request $request)
    {
        $data = json_decode(
            self::curl_post(['action' => $request->action, 'url' => $request->url]),
            true
        );
        if (empty($data)) {
            return response()->json('Данные не найдены', 404);
        } else {
            return response()->json($data, 201);
        }
    }
}
