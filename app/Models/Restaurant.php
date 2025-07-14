<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    //

    protected $fillable = ['name','slug','address','phone','categories_id','image'];

    public function category()
    {
        return $this->belongsTo(Category::class,'categories_id');
    }
    public function meal()
    {
        return $this->hasMany(Meal::class);
    }
}
