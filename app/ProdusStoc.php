<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdusStoc extends Model
{
    protected $table = 'produse_stocuri';
    protected $guarded = [];

    public function path()
    {
        return "/produse-stocuri/{$this->id}";
    }

    public function produs()
    {
        return $this->belongsTo('App\Produs', 'produs_id');
    }

    public function furnizor()
    {
        return $this->belongsTo('App\Furnizor', 'furnizor_id');
    }

    public function nir()
    {
        return $this->hasOne('App\Nir', 'produs_stoc_id');
    }
}
