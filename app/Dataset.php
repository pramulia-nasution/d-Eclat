<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    protected $fillable=['code','gender','usia','pendidikan','pekerjaan','tes','pemakaian'];
}
