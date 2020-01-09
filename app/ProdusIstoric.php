<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdusIstoric extends Model
{
    protected $table = 'produse_istoric';
    protected $guarded = [];

    public function path()
    {
        return "/produse_istoric/{$this->id}";
    }

    public function produs()
    {
        return $this->belongsTo('App\Produse', 'produs_id');
    }
}
