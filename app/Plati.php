<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plati extends Model
{
    protected $table = 'plati';
    protected $guarded = [];

    public function path()
    {
        return "/plati/{$this->id}";
    }
}
