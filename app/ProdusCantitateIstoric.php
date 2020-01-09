<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdusCantitateIstoric extends Model
{
    protected $table = 'produse_cantitati_istoric';
    protected $guarded = [];

    public function path()
    {
        return "/produse_cantitati_istoric/{$this->id}";
    }

    public function produs()
    {
        return $this->belongsTo('App\Produse', 'produs_id');
    }
}
