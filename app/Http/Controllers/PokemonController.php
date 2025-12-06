<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pokemon;

class PokemonController extends Controller
{
    public function getPokemons(Request $r)
    {
        $limit = $r->limit ?? 20;    
        $offset = $r->offset ?? 0;

        $url = "https://pokeapi.co/api/v2/pokemon?offset=${offset}&limit=${limit}";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        $pokemons = [];

        foreach($data['results'] as $poke_result){
            $poke = new Pokemon();
            $poke->url = $poke_result['url'];
            $poke->name = $poke_result['name'];
            $pokemons[] = $this->getPokemonDetail($poke);
        }

        return response()->json($pokemons, 200);
    }

    public function getPokemonDetail($poke){     
    
        $url = $poke->url;
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        $poke->id = $data['id'];
        $poke->photo = $data['sprites']['other']['official-artwork']['front_default'] ?? null;
        $poke->height = $data['height']/10;
        $poke->weight = $data['weight']/10;
        $poke->types = $data['types'];

        return $poke;
        
    }

    public function getPokemonDetailById(Request $r){     
        $r->validate([
            'pokemon_id' => 'required|integer'
        ]);

        $id = $r->pokemon_id;
        $url = "https://pokeapi.co/api/v2/pokemon/${id}/";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        $poke = new Pokemon();
        $poke->id = $data['id'];
        $poke->name = $data['name'];
        $poke->photo = $data['sprites']['other']['official-artwork']['front_default'] ?? null;
        $poke->height = $data['height']/10;
        $poke->weight = $data['weight']/10;
        $poke->types = $data['types'];

        return response()->json($poke, 200);
        
    }

}
