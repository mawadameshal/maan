<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model {
	//
	protected $table = "forms";
	protected $fillable = ['title', 'type', 'citizen_id', 'project_id', 'sent_type' ,  'response_type'
		, 'category_id','evaluate' ,'evaluate_note','status','is_report','follow_reason_not', 'content', 'datee', 'account_id','required_respond' , 'form_file' , 'form_data'
        ,'show_data','type_of_followup_visit','old_category_id'];

	public function citizen() {
		return $this->belongsTo('App\Citizen');
	}

	public function user_change_category() {
		return $this->belongsTo('App\User');
	}

	public function user_change_content() {
		return $this->belongsTo('App\Account');
	}

	public function user_recommendations_for_deleting() {
		return $this->belongsTo('App\Account');
	}

	public function user_reprocessing_recommendations() {
		return $this->belongsTo('App\Account');
	}

	public function sent_typee() {
		return $this->hasOne('App\Sent_type', 'id', 'sent_type');
	}

	public function form_type() {
		return $this->hasOne('App\Form_type', 'id', 'type');
	}

	public function form_status() {
		return $this->hasOne('App\Form_status', 'id', 'status');
	}

	public function account() {
		return $this->belongsTo('App\Account');
	}

	public function deleted_user() {
        return $this->hasOne('App\User',  'id','deleted_by');

    }

	public function category() {
		return $this->belongsTo('App\Category');
	}

    public function old_category() {
		return $this->belongsTo('App\Category');
	}

	public function project() {
		return $this->belongsTo('App\Project');
	}

	public function form_follow() {
		return $this->hasMany('App\Form_follow');
	}

	public function form_response() {
		return $this->hasMany('App\Form_response');
	}

	function form_file() {
		return $this->hasOne('App\Form_file', 'form_id');
	}

	public function form_files() {
		return $this->hasMany('App\Form_file', 'form_id');
	}

	public function all_replies() {
		$messages1 = collect(

			$this->form_response()->orderBy('created_at', 'desc')->get()
		);

		$messages1 = $messages1->sortByDesc('created_at');

		$messages2 = collect(
			$this->form_follow()->orderBy('created_at', 'desc')->get()
		);

		$messages2 = $messages2->sortByDesc('created_at');

		$messages = $messages1->merge($messages2);

		$messages = $messages->toArray();

		$messages = quick_sort($messages);

		return $messages;
	}
}
