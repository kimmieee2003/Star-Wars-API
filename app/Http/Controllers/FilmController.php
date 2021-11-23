<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
    // Deze functie stuurt de user naar de swapi.blade.php met een volledige lijst van films.
    public function index()
    {
        $client = new Client();
        $api_response = $client->get('https://swapi.dev/api/films/');
        $stream = $api_response->getBody();
        $contents = json_decode($stream);
        return view('swapi_views/swapi', compact('contents'));
    }

    // Deze functie haalt een specifieke film op aan de hand van de film id.
    public function film($id)
    {
        $client = new Client();
        $api_response = $client->get("https://swapi.dev/api/films/$id");
        $stream = $api_response->getBody();
        $contents = json_decode($stream);
        return view('swapi_views/film', compact('contents'));
    }

    // Deze functie haalt een specifieke film op aan de hand van de film id die word meegegeven via de zoekbalk.
    public function filmsearch()
    {
        $client = new Client();
        $data = request()->all();
        $id = $data['filmid'];
        $api_response = $client->get("https://swapi.dev/api/films/$id");
        $stream = $api_response->getBody();
        $contents = json_decode($stream);
        return view('swapi_views/film', compact('contents'));
    }

    // Deze functie slaat een film op aan de database als een favoriete en opent daarna de complete lijst weer.
    public function filmfavorites()
    {
        $client = new Client();
        $data = request()->all();
        $id = $data['filmid'];
        $title = $data['filmtitle'];
        $episode = $data['filmid'];
        if ($id == 1 || $id == 2 || $id == 3) {
            $id = $id + 3;
        } elseif ($id == 4 || $id == 5 || $id == 6) {
            $id = $id - 3;
        }
        DB::insert("insert into films (film_id, title, episode_id) values (?, ?, ?)", [$id, $title, $episode]);
        $api_response = $client->get('https://swapi.dev/api/films/');
        $stream = $api_response->getBody();
        $contents = json_decode($stream);
        return view('swapi_views/swapi', compact('contents'));
    }

    // Deze fnctie verwijderd een film uit de favorieten.
    public function removefavorites()
    {
        $client = new Client();
        $data = request()->all();
        $id = $data['filmid'];
        DB::delete("delete from films where film_id = $id");
        $api_response = $client->get('https://swapi.dev/api/films/');
        $stream = $api_response->getBody();
        $contents = json_decode($stream);
        return view('swapi_views/swapi', compact('contents'));
    }

    // Deze functie verwijderd een film uit de favorieten en opent daarna de favorieten lijst weer.
    public function removefavoritesfromfavorites()
    {
        $data = request()->all();
        $id = $data['filmid'];
        DB::delete("delete from films where film_id = $id");
        $query = DB::select("select * from films");
        $contents = [];
        foreach ($query as $film) {
            $filmid = $film->film_id;
            $client = new Client();
            $api_response = $client->get("https://swapi.dev/api/films/$filmid");
            $stream = $api_response->getBody();
            $filmdata = json_decode($stream);
            array_push($contents, $filmdata);
        }
        return view('swapi_views/favorite', compact('contents'));
    }

    // Deze functie laat een overzicht van alle films die als favorieten zijn opgeslagen.
    public function seeAllFavorites()
    {
        $query = DB::select("select * from films");
        $contents = [];
        foreach ($query as $film) {
            $id = $film->film_id;
            $client = new Client();
            $api_response = $client->get("https://swapi.dev/api/films/$id");
            $stream = $api_response->getBody();
            $filmdata = json_decode($stream);
            array_push($contents, $filmdata);
        }
        return view('swapi_views/favorite', compact('contents'));
    }
}