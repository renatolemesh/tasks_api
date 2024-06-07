<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $todos = $user->role === 'admin' ? Todo::all() : $user->todos; //verifica se é admin, e mostra os Todos, mostra todos se for admin, ou os do usuário se não for admin.

        return response()->json($todos);
    }

    public function show(Request $request, Todo $todo)
    {
        $user = $request->user();

        if ($user->role !== 'admin' && $todo->user_id !== $user->id) { //verifica se o Todo é do usuário ou se o usuário é admin
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json($todo); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $user = $request->user();

        $data = [
            'title'=>$request->title,
            'user_id'=>$user->id,
        ];

        $todo = Todo::create($data); //cria um Todo com os dados recebidos
        
        return response()->json($todo, 201);
    }

    public function update(Request $request, Todo $todo)
    {
        $user = $request->user();

        if ($user->role !== 'admin' && $todo->user_id !== $user->id) { 
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $todo->update($request->only('title')); //faz update do titulo

        return response()->json($todo); //retorna o resultado
    }

    public function destroy(Request $request, Todo $todo)
    {
        $user = $request->user();

        if ($user->role !== 'admin' && $todo->user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $todo->delete(); //função para deletar 

        return response()->json(['message' => 'Todo deleted successfully']);
    }
}