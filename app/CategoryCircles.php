<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryCircles extends Model
{
    //
    protected $table = "category_circles";
    protected $fillable =['category','main_category','sub_category','procedure_type','circle'];

    public function circle(){
        return $this->belongsTo('App\Circle');
    }
    public function category(){
        return $this->belongsTo('App\Category');
    }

}
