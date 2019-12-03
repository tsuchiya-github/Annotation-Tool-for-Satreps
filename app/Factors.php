<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factors extends Model
{
    protected $table = "factors";

    protected $guarded = ['_token'];

    public $timestamps = false;
}
