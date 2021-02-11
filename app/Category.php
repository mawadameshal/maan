<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = "categories";
    protected $fillable =['name',  'main_category_id' , 'main_suggest_id' , 'is_complaint', 'benefic_msg','citizen_msg','benefic_wait','citizen_wait','citizen_show','benefic_show'];

    public function form(){
        return $this->hasMany('App\Form');
    }
    public function circles()
    {
        return $this->belongsToMany('App\Circle');
    }
    public function circle_categories()
    {
        return $this->hasMany('App\CircleCategories');
    }

    public function parentCategory(){
        return $this->belongsTo(MainCategory::class , 'main_category_id' , 'id');
    }

    public function parentSuggest(){
        return $this->belongsTo(MainCategory::class , 'main_suggest_id' , 'id');
    }


}
