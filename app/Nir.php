<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nir extends Model
{
    protected $table = 'niruri';
    protected $guarded = [];

    public function path()
    {
        return "/niruri/{$this->id}";
    }

    public function produs_stoc()
    {
        return $this->belongsTo('App\ProdusStoc', 'produs_stoc_id');
    }
}
