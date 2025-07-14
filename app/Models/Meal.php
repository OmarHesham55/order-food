<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    //
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    protected $fillable = [
        'restaurant_id',
        'name',
        'description',
        'price',
        'image'
    ];
}
