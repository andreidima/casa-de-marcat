<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriiProduse extends Model
{
    protected $table = 'categorii_produse';
    protected $guarded = [];

    public function path()
    {
        return "/categorii_produse/{$this->id}";
    }
}
