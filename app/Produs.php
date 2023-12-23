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

    public function cantitati()
    {
        return $this->hasMany('App\ProdusCantitateIstoric', 'produs_id');
    }

    public function produs_inventar_verificare()
    {
        return $this->hasOne('App\ProdusInventarVerificare', 'produs_id');
    }

    public function produse_stocuri()
    {
        return $this->hasMany('App\ProdusStoc', 'produs_id');
    }

    public function produse_stocuri_ultimele()
    {
        return $this->hasMany('App\ProdusStoc', 'produs_id')->orderBy('created_at', 'DESC');
    }

    public function produse_stocuri_ultimul_stoc()
    {
        return $this->hasOne('App\ProdusStoc', 'produs_id')->latest();
    }
}
