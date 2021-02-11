<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountProjects extends Model
{
    //
    protected $table = "account_project";
    protected $fillable =['account_id','project_id','rate','to_add','to_edit','to_delete','to_replay','to_stop','to_notify'];

    public function projects(){
        return $this->belongsTo('App\Project');
    }
    public function account_rate()
    {
        return $this->hasOne('App\Account_rate','id','rate');
    }
    public function account(){
        return $this->belongsTo('App\Account');
    }
}
