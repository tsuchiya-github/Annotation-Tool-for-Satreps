<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nationalities extends Model
{
    protected $table = "nationalities";

    protected $guarded = ['_token'];

    public $timestamps=false;
}
