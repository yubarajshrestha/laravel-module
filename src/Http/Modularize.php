<?php

namespace YubarajShrestha\YM\Http;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Modularize extends Eloquent
{
    protected $table = 'modularize';

    protected $fillable = [
        'title', 'slug',
    ];
}
