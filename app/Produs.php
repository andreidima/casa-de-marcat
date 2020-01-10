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

    public function subcategorie()
    {
        return $this->belongsTo('App\SubcategoriiProduse', 'subcategorie_produs_id');
    }

    public function produse_vandute()
    {
        return $this->hasMany('App\ProdusVandut', 'produs_id');
    }
}