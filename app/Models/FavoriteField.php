<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteField extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'ff_complex_id';
    protected $guarded = [];
}
