<?php

namespace App;

use Illuminate\database\Eloquent\Model;

class Object_name extends Model
{
    protected $table = "object_name";

    protected $guarded = ['_token'];

    public $timestamps = false;
}

?>