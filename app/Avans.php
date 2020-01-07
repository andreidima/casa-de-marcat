<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avans extends Model
{
    protected $table = 'avansuri';
    protected $guarded = [];

    public function path()
    {
        return "/avansuri/{$this->id}";
    }
}
