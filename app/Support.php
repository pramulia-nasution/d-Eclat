<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $table = 'support';
    protected $fillable=['supp'];
    public $timestamps = false;
}
