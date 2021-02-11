<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form_file extends Model
{
    //
    protected $table = "form_files";
    protected $fillable =['form_id','name','path'];
    
    function form(){
        return $this->belongsTo('App\Form');
    }
}
