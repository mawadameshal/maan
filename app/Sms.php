<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    //
    protected $table = "sms";
    protected $fillable =['mobile', 'message_type_id', 'message_text', 'count_message','name'];


}
