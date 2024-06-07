<?php

namespace Database\Seeders;
use App\Models\TodoItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TodoItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TodoItem::factory()
            ->count(10)
            ->create();
    }
}
