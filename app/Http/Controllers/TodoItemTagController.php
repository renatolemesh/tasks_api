<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodoItem;
use App\Models\Tag;

class TodoItemTagController extends Controller
{
   
    public function index(Request $request, $item_id)
    {
        $user = $request->user();
        $item = TodoItem::findOrFail($item_id); //verifica se o item existe

        // Verifica se o usuário é admin ou se o item pertence ao usuário
        if ($user->role !== 'admin' && $item->todo->user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $tags = $item->tags; 
        return response()->json($tags); //retorna as tags (inteiras)

    }

    
    public function store(Request $request, $itemId)
    {
        $request->validate([ 
            'tag_id' => 'required|integer',
        ]);

        $item = TodoItem::findOrFail($itemId);

        $user = $request->user(); 
        if ($user->role !== 'admin' && $item->todo->user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        } //verificação do usuário

        $tag = Tag::findOrFail($request->tag_id); //verifica se a tag informada existe
        $item->tags()->attach($tag); //vincula a tag com o item

        return response()->json(['message' => 'Tag attached successfully','data' => $item->tags], 200); //retorna as tags
    }
    
    
    public function destroy(Request $request, $itemId)
    {
        $request->validate([
            'tag_id' => 'required|exists:tags,id',
        ]);

        $item = TodoItem::findOrFail($itemId);
        $tag = Tag::findOrFail($request->tag_id);
        
        $user = $request->user(); 
        if ($user->role !== 'admin' && $item->todo->user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $item->tags()->detach($tag); //desanexa as tags conforme array enviado

        return response()->json(['message' => 'Tag detached successfully', 'data' => $item->tags], 200); //retorna o resultado

    }
}
