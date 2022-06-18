<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'due_date',
        'status',
        'finished',
        'tag',
    ];

    public function dueDate(): Attribute
    {
        return new Attribute(
            set: fn ($value) => date('Y-m-d', strtotime($value))
        );
    }
}
