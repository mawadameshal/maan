<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $table = "recommendations";
    protected $fillable =['content', 'form_id','user_id'];

    public function form(){
        return $this->hasMany('App\Form');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

}
