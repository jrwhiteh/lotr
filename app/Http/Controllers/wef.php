<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class wef extends Controller
{
    public $client;
    public $url;

    //zUbByiNPFrM80P3H2Rwx

    public function __construct()
    {
        $apiKey = env('API_KEY');
        $this->client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
            ]
        ]);
        $this->url = 'https://the-one-api.dev/v2';
    }

    // all books
    public function getAllBooks()
    {
        $response = $this->client->request('GET', $this->url . '/book');
        $books = json_decode($response->getBody()->getContents());
        return response()->json($books);
    }

    // get book with filter
    public function getBookWithFilter(Request $request)
    {
        $queryParams = $request->query();
        if (!empty($queryParams)) {
            $this->url .= '/book?' . http_build_query($queryParams);
        }
        $response = $this->client->request('GET', $this->url);
        $characters = json_decode($response->getBody()->getContents());
        return response()->json($characters);
    }

    // download all characters no pagination
    public function getAllCharacters()
    {
        $response = $this->client->request('GET', $this->url . '/character');
        $characters = json_decode($response->getBody()->getContents());
        return response()->json($characters);
    }

    // get character with filter
    // this can be used to get the characters name and other details
    public function getCharacterWithFilter(Request $request) {
        $queryParams = $request->query();
        if (!empty($queryParams)) {
            $this->url .= '/character?' . http_build_query($queryParams);
        }
        $response = $this->client->request('GET', $this->url);
        $characters = json_decode($response->getBody()->getContents());
        return response()->json($characters);
    }

    // get all movies with pagination
    public function getAllMovies(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $response = $this->client->request('GET', $this->url . '/movie', [
            'query' => [
                'page' => $page,
                'limit' => $limit
            ]
        ]);
        $movies = json_decode($response->getBody()->getContents());
        return response()->json($movies);
    }

    // get movie with filter
    public function getMovieWithFilter(Request $request)
    {
        $queryParams = $request->query();
        if (!empty($queryParams)) {
            $this->url .= '/movie?' . http_build_query($queryParams);
        }
        $response = $this->client->request('GET', $this->url);
        $movies = json_decode($response->getBody()->getContents());
        return response()->json($movies);
    }

}
