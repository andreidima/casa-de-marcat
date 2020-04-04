<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Furnizor extends Model
{
    protected $table = 'furnizori';
    protected $guarded = [];

    public function path()
    {
        return "/furnizori/{$this->id}";
    }
}
