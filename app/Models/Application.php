<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'lead_id',
        'user_id',
        'status', // 0 - Rejected, 1-approved, 2- in progress
    ];
}
