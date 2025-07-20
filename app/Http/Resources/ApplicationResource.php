<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'status'   => $this->status,
            'applied_at' => $this->created_at,
            $this->mergeWhen($this->relationLoaded('volunteer') && $this->volunteer, function () {
                return [
                    'user' => [
                        'id' => $this->volunteer->id,
                        'name' => $this->volunteer->name,
                        'email' => $this->volunteer->email,
                    ]
                ];
            }),
            'opportunity' => [
                'id'         => $this->opportunity->id,
                'title'      => $this->opportunity->title,
                'location'   => $this->opportunity->location,
                'category'   => $this->opportunity->category?->name,
                'organizer'  => $this->opportunity->organizer?->name,
                'start_date' => $this->opportunity->start_date,
                'end_date'   => $this->opportunity->end_date,
            ],
        ];
    }
}
