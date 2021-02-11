<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageType extends Model {
	//
	protected $table = "message_type";
	protected $fillable = ['name', 'text'];

}
