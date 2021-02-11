<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form_status extends Model
{
    //
    protected $table = "form_status";
    protected $fillable = ['name'];

    public function form()
    {
        return $this->belongsTo('App\Form','id','status');
    }
}