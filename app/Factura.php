<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturi';
    protected $guarded = [];

    public function path()
    {
        return "/facturi/{$this->id}";
    }

    public function produse()
    {
        return $this->hasMany('App\FacturaProdus', 'factura_id');
    }    
}
