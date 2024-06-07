<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoItemTag extends Model
{
    protected $fillable = [
        'todo_item_id',
        'tag_id'
    ];

}
