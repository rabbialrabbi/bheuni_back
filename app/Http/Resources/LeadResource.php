<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
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
            'notes' => $this->note,
            'status' => (string)$this->status,
            'status_name' => config('dropdown.lead_status')[$this->status],
            'counselor' => $this->counselor_id ? $this->counselor->name : null,
            'counselor_id' => $this->counselor_id,
        ];
    }
}
