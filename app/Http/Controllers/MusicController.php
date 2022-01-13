<?php

namespace App\Http\Controllers;

use App\Models\Musics;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MusicController extends Controller
{
    function addMusic(Request $request)
    {
        $resoult =  getPage($request->url);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($resoult);
        $xpath = new DOMXPath($dom);
        libxml_use_internal_errors(true);
        $image =  $xpath->query('//*[@id="app"]/div[2]/div[2]/div/div[1]/div[1]/div[1]/div', $dom)->item(0);
        preg_match_all("/\((.+?)\)/", $image->attributes->getNamedItem('style')->nodeValue, $matches);
        $image = 'https:' . $matches[1][0];
        $ramdom_name = 'public/' . Str::random(40) . '.jpeg';
        Storage::put($ramdom_name, getPage($image));
        $contents = '/public' . Storage::url($ramdom_name);
        $music = Musics::create([
            'title' => $request->title,
            'author' => $request->author ?? ' ',
            'album' => $request->album,
            'image' =>  $contents,
            'url' => $request->url,
        ]);
        return response()->json(null, 204);
    }
    function getMusic(Request $request)
    {
        $resoult =  getPage($request->url);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($resoult);
        $xpath = new DOMXPath($dom);
        libxml_use_internal_errors(true);
        $title =  $xpath->query('//*[@id="app"]/div[2]/div[2]/div/div[1]/div[1]/div[2]/h1', $dom)->item(0);
        $author =  $xpath->query('//*[@id="app"]/div[2]/div[2]/div/div[1]/div[1]/div[2]/h2[1]', $dom)->item(0);
        $image =  $xpath->query('//*[@id="app"]/div[2]/div[2]/div/div[1]/div[1]/div[1]/div', $dom)->item(0);
        preg_match_all("/\((.+?)\)/", $image->attributes->getNamedItem('style')->nodeValue, $matches);
        $image = 'https:' . $matches[1][0];
        return response()->json(['music' => [
            'title' => $title->textContent,
            'authorName' => $author->textContent,
            'album' => null,
            'coverThumb' => $image,
        ]], 200);
    }
    function musicList()
    {
        $musics= Musics::get();
        return response()->json($musics, 200);
    }
}

function getPage($url)
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
