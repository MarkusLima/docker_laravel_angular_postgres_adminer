<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'method',
        'url',
        'headers',
        'body',
        'status_code',
        'response_body',
    ];

    protected $casts = [
        'headers' => 'array',
        'body' => 'array',
        'response_body' => 'array',
    ];
}
