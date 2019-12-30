<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produs extends Model
{
    protected $table = 'produse';
    protected $guarded = [];

    public function path()
    {
        return "/produse/{$this->id}";
    }

    public function categorie()
    {
        return $this->belongsTo('App\CategoriiProduse', 'categorie_produs_id');
    }
}