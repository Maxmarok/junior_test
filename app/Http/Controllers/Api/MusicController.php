<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddMusicRequest;
use App\Http\Resources\Music\GetMusicListResource;
use App\Models\Music;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MusicController extends Controller
{

    public function addMusic(AddMusicRequest $request)
    {
        $newData = $request->validated();
        $musicInfo = $this->getMusicInfo($newData['url']);
        if (!empty($musicInfo['music']['coverThumb'])) {
            $dataForStorage = file_get_contents($musicInfo['music']['coverThumb']);
            $filename = "\MusicImages\\" .time(). "_" . Str::uuid();
            file_put_contents(storage_path("app\public{$filename}"), $dataForStorage);
            $filename = Str::replace('\\','/',$filename);
            $newData['image'] = "/storage{$filename}";
        } else {
            $newData['image'] = '/img/blankAvatar.png';
        }
        $music = Music::updateOrCreate(['url' => $newData['url']],$newData);
        return response()->json(['status' => true]);
    }

    public function getMusic(Request $request)
    {
        $url = $request->input('url');
        return response()->json($this->getMusicInfo($url));
    }
    public function getMusicList()
    {
        $musicList = Music::all();
        return response()->json(GetMusicListResource::collection($musicList));
    }
    protected function getMusicInfo(string $url)
    {
        $client = new Client(['base_uri' => 'https://parser.peak.promo']);
        $response = $client->request(
            'POST',
            '/',
            [
                'json' =>
                    [
                        'action' => 'getMusic',
                        'url' => $url,
                    ]
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }
}
