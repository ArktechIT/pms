<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PartCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // dump($request);
        return [
            'draw' => $request['draw'],
            'recordsTotal' => $request['recordsTotal'],
            'recordsFiltered' => $request['recordsFiltered'],
            'data' => $this->collection
        ];
    }
}
