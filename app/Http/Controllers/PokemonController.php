<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PokemonController extends Controller
{
    public function getPokemons(Request $r)
    {
        $limit = $r->limit ?? 20;    
        $offset = $r->offset ?? 0;

        $url = "https://pokeapi.co/api/v2/pokemon?offset=${offset}&limit=${limit}";

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return response()->json($data, 200);
    }
}
