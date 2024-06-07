<?php

namespace Database\Factories;
use App\Models\Tag;
use App\Models\TodoItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TodoItemTag>
 */
class TodoItemTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tag_id' => Tag::latest()->first()->id,
            'todo_item_id' => TodoItem::latest()->first()->id,
        ];
    }
}
