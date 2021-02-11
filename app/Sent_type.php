<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sent_type extends Model
{
    //
    protected $table = "sent_type";
    protected $fillable = ['name'];

    public function form()
    {
        return $this->belongsTo('App\Form','id','sent_type');
    }
}