<?php

namespace App;

use Illuminate\database\Eloquent\Model;

class Tsuchiyaweb extends Model
{
    protected $table = "tsuchiyaweb";

    protected $guarded = ['_token'];

    public $timestamps=false;

}

?>