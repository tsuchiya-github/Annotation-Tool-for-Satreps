<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image_database extends Model
{
    protected $table = "image_database";

    protected $guarded = ['_token'];

    public $timestamps=false;
}
