<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description'
    ];

    protected $attributes = [
        'description' => null
    ];

    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class, 
            TodoItemTag::class
        );
    }
}
