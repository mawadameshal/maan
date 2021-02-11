<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EvaluateResource extends JsonResource
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
            'form_id' => $this->form_id,
            'citizen_id' => $this->citizen_id,
            'solve' => $this ->solve,
            'evaluate' => $this->evaluate,
            'notes' => $this->notes,
            'datee' => $this->datee
        ];
    }
}
