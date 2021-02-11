<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //

    protected $table = "accounts";

    protected $fillable =['circle_id','email','type','user_name','id_number','full_name','mobile','image'
        ,'user_id'];

    function user(){
        return $this->hasOne('App\User','id','user_id');
    }

    public function links()
    {
        return $this->belongsToMany('App\Link');
    }
    public function projects()
    {
        return $this->belongsToMany('App\Project');
    }
    public function account_projects()
    {
        return $this->hasMany('App\AccountProjects');
    }
    public function circle(){
        return $this->belongsTo('App\Circle');
    }
    public function forms()
    {
        return $this->hasMany('App\Form');
    }
    public function form_response()
    {
        return $this->hasMany('App\Form_response');
    }

    public function messages()
    {
        return [
            'full_name.required' => 'A title is required',
        ];
    }
}
