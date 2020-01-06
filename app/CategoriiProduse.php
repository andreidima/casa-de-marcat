<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriiProduse extends Model
{
    protected $table = 'categorii_produse';
    protected $guarded = [];

    public function path()
    {
        return "/categorii_produse/{$this->id}";
    }

    public function subcategorii()
    {
        return $this->hasMany('App\SubcategoriiProduse', 'categorie_produs_id');
    }

    public function produse()
    {
        return $this->hasManyThrough('App\Produs', 'App\SubcategoriiProduse', 'categorie_produs_id', 'subcategorie_produs_id', 'id', 'id');
    }
}
