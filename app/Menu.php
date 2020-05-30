<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $table='Menu';
    protected $primaryKey='idMenu';
    public $timestamps=false;
}
