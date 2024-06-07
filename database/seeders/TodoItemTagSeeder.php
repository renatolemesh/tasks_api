<?php

namespace Database\Seeders;
use App\Models\TodoItemTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TodoItemTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TodoItemTag::factory()
            ->count(5)
            ->create();
    }
}
