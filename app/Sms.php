<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    //
    protected $table = "sms";
    protected $fillable =['mobile', 'message_type_id', 'citizen_id','form_id','user_id'];

}
