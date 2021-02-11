<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CircleCategories extends Model
{
    //
    protected $table = "circle_categorie";
    protected $fillable =['circle_id','category_id','rate','to_add','to_edit','to_delete','to_replay','to_stop','to_notify'];

    public function circle(){
        return $this->belongsTo('App\Circle');
    }
    public function category(){
        return $this->belongsTo('App\Category');
    }

}
