<?php

namespace App\Http\Controllers;

use App\Models\Music;
use Illuminate\Http\Request;

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

    }

    public function listMusicView(Request $request, Music $musics)
    {
        $musics = Music::all();
        return view('list',compact('musics'));
    }

    public function getMusicView()
    {
        return view('get');
    }
    public function getMusic(Request $request)
    {
        $curl= false;
        $request->validate([
            "curl"=>"required"
        ]);
        return redirect("https://parser.peak.promo/". $request->curl);
    }
}
