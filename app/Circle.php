<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Circle extends Model
{
    //
    protected $table = "circles";
    protected $fillable =['name'];

    public function Account(){
        return $this->hasMany('App\Account');
    }
    public function category()
    {
        return $this->belongsToMany('App\Category','circle_categorie');
    }
    public function circle_categories()
    {
        return $this->hasMany('App\CircleCategories');
    }

//    public function category1()
//    {
//        return $this->belongsToMany('App\Category','category_circles');
//    }
//    public function category_circles()
//    {
//        return $this->hasMany('App\CategoryCircles');
//    }
}
