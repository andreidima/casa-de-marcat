<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LucrareCategorie extends Model
{
    protected $table = 'lucrari_categorii';
    protected $guarded = [];

    public function path()
    {
        return "/lucrari/categorii/{$this->id}";
    }
}
