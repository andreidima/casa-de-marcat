<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaProdus extends Model
{
    protected $table = 'facturi_produse';
    protected $guarded = [];

    public function path()
    {
        return "/facturi-produse/{$this->id}";
    }

    public function factura()
    {
        return $this->belongsTo('App\Factura', 'factura_id');
    }
}
