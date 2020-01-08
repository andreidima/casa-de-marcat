<?php

namespace App;

use App\Produs;

use Illuminate\Support\Facades\DB;
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

    public function suma_totala()
    {
        return Produs::where('subcategorie_produs_id', $this->attributes['id'])
            ->sum(DB::raw('cantitate * pret'));
        // sum(DB::raw('cantitate * pret') $this->attributes['prix'] * $this->attributes['quantitevendu'];
    }
}
