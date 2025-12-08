<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/user/create', [UserController::class, 'create']);

Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');//middleware sanctum adiona autenticação, tenho q passar o token no Header

Route::get('pokemon/getPokemons', [PokemonController::class, 'getPokemons'])->middleware('auth:sanctum'); 
Route::post('pokemon/getPokemon', [PokemonController::class, 'getPokemonDetailById'])->middleware('auth:sanctum'); 
Route::post('pokemon/getPokemonByName', [PokemonController::class, 'getPokemonDetailByName'])->middleware('auth:sanctum'); 

Route::post('team/create', [TeamController::class, 'createTeam'])->middleware('auth:sanctum'); 
Route::put('team/edit', [TeamController::class, 'editTeam'])->middleware('auth:sanctum'); 
Route::post('team/delete', [TeamController::class, 'deleteTeam'])->middleware('auth:sanctum'); 
Route::get('team/getAll', [TeamController::class, 'getAll'])->middleware('auth:sanctum'); 
Route::post('team/get', [TeamController::class, 'getTeamById'])->middleware('auth:sanctum'); 