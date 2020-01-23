<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdusInventarVerificare extends Model
{
    protected $table = 'produse_inventar_verificare';
    protected $guarded = [];

    public function path()
    {
        return "/produse-inventar-verificare/{$this->id}";
    }

    public function produs()
    {
        return $this->belongsTo('App\Produs', 'produs_id');
    }
}
