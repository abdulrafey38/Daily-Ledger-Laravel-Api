<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $guarded =[];

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
