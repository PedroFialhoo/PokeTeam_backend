<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $fillable = [
        'team_id',
        'pokemon_id',
    ];

    public $url;
    public $name;
    public $type;
    public $types = [];
    public $photo;
    public $photo_shiny;
    public $height;
    public $weight;
    public $abilities = [];
    public $status = [];

    protected $appends = ['url','name', 'photo', 'photo_shiny', 'types', 'height', 'weight', 'abilities', 'status'];//pra retornar junto no json do pokemon, mesmo sem estar no banco

    public function getUrlAttribute(){ 
        return $this->url; 
    }
    public function getNameAttribute(){ 
        return $this->name; 
    }
    public function getPhotoAttribute(){
        return $this->photo; 
    }
    public function getPhotoShinyAttribute(){
        return $this->photo_shiny;
    }
    public function getTypesAttribute(){
        return $this->types; 
    }
    public function getHeightAttribute(){
        return $this->height; 
    }
    public function getWeightAttribute(){
        return $this->weight; 
    }
    public function getAbilitiesAttribute(){
        return $this->abilities; 
    }
    public function getStatusAttribute(){
        return $this->status; 
    }

    public function team(){
        return $this->belongsTo(Team::class);
    }
}
