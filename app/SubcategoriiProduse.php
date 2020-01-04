<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubcategoriiProduse extends Model
{
    protected $table = 'subcategorii_produse';
    protected $guarded = [];

    public function path()
    {
        return "/subcategorii_produse/{$this->id}";
    }

    public function categorie()
    {
        return $this->belongsTo('App\CategoriiProduse', 'categorie_produs_id');
    }

    public function produse()
    {
        return $this->hasMany('App\Produs', 'subcategorie_produs_id');
    }
}
