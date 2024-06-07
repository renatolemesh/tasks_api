<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodoItem;
use App\Models\Todo;
use App\Models\Tag;

class TodoItemController extends Controller
{
    public function index(Request $request, $todoId)
    {
        $user = $request->user();
        $todo = Todo::findOrFail($todoId); //procura o Todo pelo id 

        if ($user->id !== $todo->user_id && $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403); //faz a verificação se o usuário é igual, ou se é admin
        } 

        return response()->json($todo->items); //retorna os items
    }

    public function store(Request $request, $todoId)
    {
        $user = $request->user();
        $todo = Todo::findOrFail($todoId);

        if ($user->id !== $todo->user_id && $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $item = new TodoItem($data); //cria um novo item com os dados
        $item->todo_id = $todo->id;
        $item->save();

        if ($request->has('tags')) {
            $tags = Tag::find($request->tags);
            $item->tags()->attach($tags);
        }

        return response()->json($item, 201);
    }

    public function show(Request $request, $todoId, $itemId)
    {
        $user = $request->user();
        $todo = Todo::findOrFail($todoId);

        if ($user->id !== $todo->user_id && $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $item = TodoItem::where('todo_id', $todo->id)->findOrFail($itemId);

        return response()->json($item);
    }

    public function update(Request $request, $todoId, $itemId)
    {
        $user = $request->user();
        $todo = Todo::findOrFail($todoId);

        if ($user->id !== $todo->user_id && $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $item = TodoItem::where('todo_id', $todo->id)->findOrFail($itemId);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'tags' => 'array',
        ]);

        $item->update($request->all());

        if ($request->has('tags')) {
            $tags = Tag::find($request->tags);
            $item->tags()->sync($tags);
        }

        return response()->json($item);
    }

    public function destroy(Request $request, $todoId, $itemId)
    {
        $user = $request->user();
        $todo = Todo::findOrFail($todoId);

        if ($user->id !== $todo->user_id && $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $item = TodoItem::where('todo_id', $todo->id)->findOrFail($itemId);
        $item->delete();

        return response()->json(null, 204);
    }
}

