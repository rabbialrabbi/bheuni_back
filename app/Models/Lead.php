<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    /** @use HasFactory<\Database\Factories\LeadFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'notes',
        'status',
        'counselor_id',
    ];

    public function counselor(){
        return $this->belongsTo(User::class, 'counselor_id');
    }
}
