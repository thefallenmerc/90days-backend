<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resolution extends Model
{
    use SoftDeletes;
    protected $guarded = ['deleted_at'];
    protected $hidden = ['deleted_at'];
}
