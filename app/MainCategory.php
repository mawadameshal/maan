<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    protected $table = "main_categories";


    protected $fillable = ['name','is_complaint'];


    public function subCategory(){
        return $this->hasMany(Category::class , 'main_category_id' , 'id');
    }

    public function subSuggest(){
        return $this->hasMany(Category::class , 'main_suggest_id' , 'id');
    }


}
