<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CalendarResource extends JsonResource
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
            'title' => $this->event_name,
            'hora' => $this->event_hora,
            'start' => $this->start_date,
            'end' => $this->end_date,
            'user' => $this->user->id,
            'user_name' => $this->user->name,
            'color' => $this->color
        ];
    }
}
