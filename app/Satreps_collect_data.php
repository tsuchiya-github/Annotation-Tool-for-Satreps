<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Satreps_collect_data extends Model
{
    protected $table = "satreps_collect_data";

    protected $guarded = ['_token'];

    public $timestamps=false;
}
