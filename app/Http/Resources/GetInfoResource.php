<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetInfoResource extends JsonResource
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

            'title' => $this->title,
            'welcom_word' => $this->welcom_word,
            'welcom_clouse' => $this->welcom_clouse,
            'add_compline_clouse' => $this->add_compline_clouse,
            'add_propusel_clouse' => $this->add_propusel_clouse,
            'add_thanks_clouse' => $this->add_thanks_clouse,
            'follw_compline_clouse' => $this->follw_compline_clouse,
            'how_we' => $this->how_we,
            'mopile' => $this->mopile,
            'phone' => $this->phone,
            'free_number' => $this->free_number,
            'mail' => $this->mail,
            'address' => $this->address,
            'fax' => $this->fax,
            'steps_file' => 'uploads/' .$this->steps_file

            
        ];
    }
}
