<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Casa extends Model
{
    protected $table = 'casa';
    protected $guarded = [];

    public function path()
    {
        return "/casa/{$this->id}";
    }
}
