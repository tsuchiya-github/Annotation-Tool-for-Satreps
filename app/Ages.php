<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ages extends Model
{
    protected $table = "ages";

    protected $guarded = ['_token'];

    public $timestamps=false;
}
