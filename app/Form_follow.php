<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form_follow extends Model {
	//
	protected $table = "form_follows";
	protected $fillable = ['form_id', 'citizen_id', 'solve'
		, 'evaluate', 'notes', 'datee','account_id','follow_form_status'];

	protected $appends = ['from_admin', 'username'];

	public function form() {
		return $this->belongsTo('App\Form');
	}
	public function citizen() {
		return $this->belongsTo('App\Citizen');
	}

	public function account() {
		return $this->belongsTo('App\Account');
	}

	public function getFromAdminAttribute() {
		return false;
	}

	public function getUsernameAttribute() {
		return $this->citizen->first_name . ' ' . $this->citizen->father_name . ' ' . $this->citizen->last_name;
	}

}
