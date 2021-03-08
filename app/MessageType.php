<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageType extends Model {
	//
	protected $table = "message_type";
	protected $fillable = ['name', 'text','count_of_letter','Remaining_letters','consumed_letters','send_procedure'];


}
