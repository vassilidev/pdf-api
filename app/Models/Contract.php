<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasUuids,
        HasFactory;

    protected $fillable = [
        'author',
        'name',
        'content',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    protected $appends = [
        'stream_url'
    ];

    protected function streamUrl(): Attribute
    {
        return Attribute::get(fn() => route('stream.contract', $this));
    }
}
