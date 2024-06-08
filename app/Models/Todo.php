<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TodoItem::class);
    }

    public function scopeByUser($query, User $user)
    {
        return $query->when(
            $user->role !== 'admin',
            fn($query) => $query->where('user_id', $user->id)
        );
    }
}
