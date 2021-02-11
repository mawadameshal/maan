<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowFormResource extends JsonResource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request) {

		return [
			[
				'id' => $this->id,
				'fullname' => $this->citizen->first_name . ' ' .
				$this->citizen->father_name . ' ' . $this->citizen->last_name,
				'mobile' => $this->citizen->mobile,
				'citizen_id' => $this->citizen->id,
				'status' => $this->form_status->name,
			//	'solve'=> $this->form_follow->solve,
				'evaluate'=>$this->evaluate,
				'notes'=>$this->evaluate_note,
				'is_report'=>$this->is_report,
				'follow_reason_not' => $this->follow_reason_not,
				'form_type'=>$this->form_type->name,
				'created_at' => $this->citizen->created_at->format('d/m/Y'),
				'sending_date' => $this->datee,
				'sending_time' => $this->created_at,
				'address' => $this->citizen->governorate . ' ' . $this->citizen->city .
				' ' . $this->citizen->street,
				'title' => $this->title,
				'content' => $this->content,
				'id_number' => $this->citizen->id_number,
				'project' => $this->project->name,
				'category' => $this->category->name,
				'sent_type' => $this->sent_typee->name,
				'files' => $this->form_files,
				'all_replies' => $this->all_replies(),

			],
		];
	}
}
