<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form_response extends Model {
	//
	protected $table = "form_responses";
	protected $fillable = ['form_id', 'account_id', 'response'
		, 'datee'];

	protected $appends = ['from_admin', 'username'];

	public function form() {
		return $this->belongsTo('App\Form');
	}

	public function account() {
		return $this->belongsTo('App\Account');
	}

    public function confirm_account() {
        return $this->belongsTo('App\Account');
    }

	public function getFromAdminAttribute() {
		return true;
	}

	public function getUsernameAttribute() {
		return $this->account->full_name;
	}

}
