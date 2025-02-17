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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'lead_id' => $this->lead_id,
            'user_id' => $this->user_id,
            'status' => (string)$this->status,
            'status_name' => config('dropdown.application_status')[$this->status]
        ];
    }
}
