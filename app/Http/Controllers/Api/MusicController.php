<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Music\AddMusic;
use App\Http\Requests\Music\GetMusic;
use App\Models\Musics;
use App\Http\Resources\Musics as MusicsResource;
use App\Services\ParserPeak\Facade\PeakParser;
use Illuminate\Support\Facades\Storage;

class MusicController extends Controller
{
    function add(AddMusic $request){
        $params = $request->validated();

        $imageUrl = PeakParser::getMusic($params['url'])['music']['coverThumb'];
        $image_content = file_get_contents($imageUrl);
        $name = explode('?', substr($imageUrl, strrpos($imageUrl, '/') + 1))[0];
        Storage::disk('covers')->put($name, $image_content);
        $params['image'] =$name;

        $music = new  Musics();
        $music->fill($params);
        $music->save();
        return response($music, 200);
    }
    function get(GetMusic $request){
        $params = $request->validated();
        $information = PeakParser::getMusic($params['url']);

//        $information['']
        return $information;
    }

    function getList(){
        return MusicsResource::collection(Musics::all())->resource;
    }
}
