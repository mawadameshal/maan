<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
                'id' => $this->id,
                'send_date' => $this->datee,
                'title' => $this ->title,
                'fullnane' => $this->citizen->first_name . ' ' . $this->citizen->father_name . ' '. $this->citizen->grandfather_name . ' ' . $this->citizen->last_name ,
                'id_number' => $this->citizen->id_number,
                'project' =>  $this->project ? $this->project ->name : '',
                'category' => $this->category ? $this->category->name : '',
                'form_status' => $this->form_status->name,
                'form_type' => $this->form_type->name,
                'mobile' => $this->citizen->mobile,
                'mobile2' => $this->citizen->mobile2,
                'governorate' => $this->citizen->governorate,
                'city' => $this->citizen->city,
                'street' => $this->citizen->street,                 
        ];
    }
}
