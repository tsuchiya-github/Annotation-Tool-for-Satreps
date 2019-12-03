<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Satreps_image_database extends Model
{
    protected $table = "satreps_image_database";

    protected $guarded = ['_token'];

    public $timestamps=false;
}
