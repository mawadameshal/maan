<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_status extends Model
{
    //
    protected $table = "project_status";
    protected $fillable = ['name'];

    public function project()
    {
        return $this->belongsTo('App\Project','id','active');
    }
}