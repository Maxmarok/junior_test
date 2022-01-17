<?php

namespace App\Http\Controllers;

use App\Models\Musics;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public const API_URL = 'https://parser.peak.promo';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $music = Musics::create([
            'title' => $request->get('title'),
            'author' => $request->get('author'),
            'album' => $request->get('album'),
            'image' => $request->get('image'),
            'url' => $request->get('url'),
        ]);

        $this->saveImageInStorage($request->get('image'));

        return response()->json(['success' => true, 'data' => $music]);
    }

    /**
     * @param Request $request
     * @return bool|string
     */
    public function getMusic(Request $request)
    {
        $data = array(
            'url' => $request->get('url'),
            'action' => 'getMusic'
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_POST => 1,
            CURLOPT_URL => self::API_URL,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    // т.к. ссылка на обложку возвращается с доп.параметрами(x-expires и x-signature),
    // используем данную функцию для получения имени обложки из реальной ссылки без параметров
    function getImageName(string $url)
    {
        return basename(substr($url, 0, strpos($url, '?x-expires')));
    }

    // сохраняем обложку из ссылки в файловой системе проекта
    function saveImageInStorage(string $imageUrl)
    {
        $albumImage = file_get_contents($imageUrl);
        $albumImageName = $this->getImageName($imageUrl);
        Storage::disk('local')->put('albums/'.$albumImageName, $albumImage);
    }

    public function getList()
    {
        $list = Musics::all();
        return response()->json(['success' => true, 'data' => $list]);
    }

}
