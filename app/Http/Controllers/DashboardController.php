<?php

namespace App\Http\Controllers;

use App\Like;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $like_popular_array = Like::select('news_id')->groupBy('news_id')->orderByRaw('COUNT(*) DESC')->limit(4)->pluck('news_id');

        $popular_users = User::whereHas('news', function ($q) use ($like_popular_array) {
            $q->whereIn('id', $like_popular_array)->where('block', 1)->where('state', 1);
        })->get();

        $bulletin = DB::table('newsletters')->get();


        // Hava Durumu - Geliştirme hızını engellememek için yorum yapıldı. SAKIN SİLME
        $client = new Client();
        $res = $client->request(
            'GET',
            'https://api.collectapi.com/weather/getWeather?data.lang=tr&data.city=istanbul',
            [
                'headers' => [
                    'authorization' => 'apikey 08eDBg0hwt79cwC0sjl2XA:0H6ohqVgqhaepxQV7UY6A1',
                    'content-type' => 'application/json'
                ]
            ]
        );

        $weather = json_decode($res->getBody());


        return view('admin.index')
            ->with('popular_users', $popular_users)
            ->with('weather', $weather)
            ->with('bulletin', $bulletin);
    }
}
