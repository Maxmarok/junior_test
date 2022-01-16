<?php

namespace App\Http\Controllers;

use App\Models\GetUrl;
use App\Models\Music;
use http\Cookie;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use MongoDB\Driver\Session;
use PhpParser\Node\Expr\Include_;
use Symfony\Component\Console\Input\Input;

class MusicController extends Controller
{

    public function addMusicView()
    {
        return view('add');
    }

    public function addMusic(Request $request, Music $music)
    {
        $request->validate([
           "title"=>"required",
           "author"=>"required",
           "album"=>"required",
           "url"=>"required",
           "photo"=>"required|file|mimes:jpg,bmp,png,jpeg|max:10240",
        ]);
        $newPhoto = explode('/',$request->file('photo')->store('public'))[1];
        $data = [
          'photo'=> $newPhoto
        ];
        $data += $request->only('title','author','album','url');
        Music::create($data);
        echo 'данные добавлены';
    }

    public function listMusicView(Request $request, Music $musics)
    {
        $musics = Music::all();
        return view('list',compact('musics'));
    }


    public function getMusic(Request $request)
    {
        $request->validate([
            "url" => "required"
        ]);
        $aaa = Http::timeout(0.01)->get($request->url);
        return $aaa;


    }

    public function getMusicView()
    {
        return view('get');


    }
}
