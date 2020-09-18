<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded =[];


    public function supplier()
    {
     return $this->belongsTo('App\Supplier');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
