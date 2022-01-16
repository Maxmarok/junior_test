<?php

namespace App\Http\Controllers;

use App\Http\Resources\MusicResource;
use App\Models\Musics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MusicController extends Controller
{
    function addMusic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'url' => 'required|unique:musics'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' =>  $validator->errors()
            ], 422);
        }
        $resoult =  getpi($request->url);
        $img = $resoult->music->coverThumb;
        $ramdom_name =  Str::random(40) . '.jpeg';
        Storage::put($ramdom_name, getImage($img));
        $path = Storage::url($ramdom_name);
        Musics::create([
            'title' => $request->title,
            'author' => $request->author ?? ' ',
            'album' => $request->album,
            'image' => $path,
            'url' => $request->url,
        ]);
        return response()->json(null, 204);
    }
    function getMusic(Request $request)
    {
        $resoult =  getpi($request->url);
        $author = null;
        if (empty($resoult->author->nickname)) {
            $author = $resoult->music->authorName;
        } else {
            $author = $resoult->author->nickname;
        }
        return response()->json(['music' => [
            'title' => $resoult->music->title,
            'authorName' =>  $author,
            'album' => $resoult->music->album,
            'coverThumb' => $resoult->music->coverThumb,
        ]], 200);
    }
    function musicList()
    {

        $musics = MusicResource::collection(Musics::get());
        return response()->json($musics, 200);
    }
}
function getImage($url)
{
    $user_agent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML,like  Gecko) Chrome/79.0.3945.130 Safari/537.36';
    $curl = curl_init($url);
    curl_setopt_array($curl, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_FOLLOWLOCATION => TRUE,
        CURLOPT_USERAGENT      => $user_agent,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT        => 10,
    ]);
    $resoult = curl_exec($curl);
    return $resoult;
}
function getpi($tikKokUrtl)
{
    $url = 'https://parser.peak.promo';
    $params = [
        'action' => 'getMusic',
        'url' => $tikKokUrtl
    ];
    $curl = curl_init($url);
    curl_setopt_array($curl, [
        CURLOPT_POST            => TRUE,
        CURLOPT_POSTFIELDS => $params,
        CURLOPT_RETURNTRANSFER => TRUE,
    ]);
    $resoult = curl_exec($curl);
    return json_decode($resoult);
}
