<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form_type extends Model
{
    //
    protected $table = "form_type";
    protected $fillable = ['name'];

    public function form()
    {
        return $this->belongsTo('App\Form','id','type');
    }
}