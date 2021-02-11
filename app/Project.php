<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $table = "projects";//manager supervisor  coordinator

    protected $fillable =['name','code','details','supervisor','manager','coordinator','support','active','start_date','end_date'];

    public function Accounts()
    {
        return $this->belongsToMany('App\Account');
    }
    public function project_status()
    {
        return $this->hasOne('App\Project_status','id','active');
    }
    public function account_projects()
    {
        return $this->hasMany('App\AccountProjects');
    }
    public function citizen_projects()
    {
        return $this->hasMany('App\CitizenProjects');
    }
    public function citizens()
    {
        return $this->belongsToMany('App\Citizen');
    }
    public function forms()
    {
        return $this->hasMany('App\Form');
    }
}
