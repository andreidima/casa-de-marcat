<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdusVandut extends Model
{
    protected $table = 'produse_vandute';
    protected $guarded = [];

    public function path()
    {
        return "/produse-vandute/{$this->id}";
    }

    public function produs()
    {
        return $this->belongsTo('App\Produs', 'produs_id');
    }
}
