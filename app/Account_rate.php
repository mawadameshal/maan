<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account_rate extends Model
{
    //
    protected $table = "account_rate";
    protected $fillable = ['name'];

    public function account_project()
    {
        return $this->belongsTo('App\AccountProjects','id','rate');
    }
}