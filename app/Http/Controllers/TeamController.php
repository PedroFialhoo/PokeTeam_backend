<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Pokemon;

class TeamController extends Controller
{
    public function createTeam(Request $r)
    {
        $r->validate([
            'name' => 'required|string',
            'pokemons_id' => 'required|array|max:5'
        ]);

        $user_id = $r->user()->id;

        $team = Team::create([
            'name' => $r->name,
            'user_id' => $user_id
        ]);

        foreach ($r->pokemons_id as $pokemon_id) {
            Pokemon::create([
                'team_id' => $team->id,
                'pokemon_id' => $pokemon_id
            ]);
        }

        return response()->json(['message' => 'Team created successfully'], 200);
    }

    public function editTeam(Request $r)
    {
        $r->validate([
            'name' => 'string',
            'pokemons_id' => 'array|max:5',
            'team_id' => 'required|integer'
        ]);

        $team = Team::find($r->team_id);
        if (!$team) {
            return response()->json(['error' => 'Team not found'], 404);
        }

        $team->name = $r->name ?? $team->name; //se eu não passar nada salva null
        $team->save();

        Pokemon::where('team_id', $team->id)->delete();//removendo todos os pokemons do time para garantir que eu nn adicione mais 5 na edição e fique com 10

        foreach ($r->pokemons_id as $pokemon_id) {
            Pokemon::create([
                'team_id' => $team->id,
                'pokemon_id' => $pokemon_id
            ]);
        }

        return response()->json(['message' => 'Team edit successfully'], 200);       

    }

    public function deleteTeam(Request $r){
        $r->validate([
            'team_id' => 'required|integer'
        ]);

        $team = Team::find($r->team_id);
        if (!$team) {
            return response()->json(['error' => 'Team not found'], 404);
        }

        Pokemon::where('team_id', $team->id)->delete();
        $team->delete();

        return response()->json(['message' => 'Team delete successfully!'], 200);
    }

    public function getAll(Request $r){
        $teams = $r->user()->teams()->with('pokemons')->get();
        foreach($teams as $team){
            foreach ($team->pokemons as $pokemon) {
                $id = $pokemon->pokemon_id;
                
                $url = "https://pokeapi.co/api/v2/pokemon/${id}/";
                $response = file_get_contents($url);
                $data = json_decode($response, true);

                $pokemon->name = $data['name'];
                $pokemon->photo = $data['sprites']['other']['official-artwork']['front_default'] ?? null;
                $pokemon->height = $data['height']/10;
                $pokemon->weight = $data['weight']/10;
                $pokemon->types = $data['types'];
            }
        }

        return response()->json([
            'message' => 'All teams',
            'teams' => $teams
        ], 200);
    }
}
