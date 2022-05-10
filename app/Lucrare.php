<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lucrare extends Model
{
    protected $table = 'lucrari';
    protected $guarded = [];

    public function path()
    {
        return "/lucrari/{$this->id}";
    }
}
