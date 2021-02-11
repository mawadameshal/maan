<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CreateCitizenResource extends JsonResource
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
                'first_name' => $this->first_name,
                'father_name' => $this->father_name,
                'grandfather_name' => $this ->grandfather_name,
                'last_name' => $this->last_name,
                'id_number' => $this->id_number,
                'governorate' => $this->governorate,
                'city' => $this->city,
                'street' => $this->street,
                'mobile' => $this->mobile,
                'mobile2' => $this->mobile2



                 
        ];
    }
}
