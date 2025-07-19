<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OpportunityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'location'    => $this->location,
            'start_date'  => $this->start_date,
            'end_date'    => $this->end_date,
            'status'      => $this->status,
            'category'    => $this->category?->name,
            'organizer'   => $this->organizer?->name,
            'created_at'  => $this->created_at,
        ];
    }
}
