<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type_of_image extends Model
{
    protected $table = "type_of_image";

    protected $guarded = ['_token'];

    public $timestamps = false;
}
