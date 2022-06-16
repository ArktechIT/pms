<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'partId' => $this->partId,
            'customerName' => $this->customer->customerName,
            'partNumber' => $this->partNumber,
            'revisionId' => $this->revisionId,
            'partNote' => $this->partNote,
            'partName' => $this->partName,
            'materialType' => $this->handleRelation($this->materialType,'materialType'),
            'metalThickness' => $this->handleRelation($this->materialSpec,'metalThickness'),
            'x' => $this->x,
            'y' => $this->y,
            'itemHeight' => $this->itemHeight,
            'itemWidth' => $this->itemWidth,
            'itemLength' => $this->itemLength,
            'itemWeight' => $this->itemWeight,
        ];
    }

    private function handleRelation($relation,$column)
    {
        try {
            return $relation->{$column};
        } catch (\Throwable $th) {
            return null;
        }
    }    
}
