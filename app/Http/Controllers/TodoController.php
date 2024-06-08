<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Requests\StoreTodoRequest;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{


    public function index(Request $request)
    {
        $user = $request->user();
        //$todos =  ? Todo::all() : $user->todos; //verifica se é admin, e mostra os Todos, mostra todos se for admin, ou os do usuário se não for admin.

        $todos = Todo::query()->byUser(user)->get();

        return response()->json($todos);
    }

    public function show(Request $request, $todoId)
    {
        $user = $request->user();

        $todos = Todo::query()->byUser(user)->findOr($todoId, fn()=> response()->json(['message' => 'Not Found'], 404));

        // if ($user->role !== 'admin' && $todo->user_id !== $user->id) { //verifica se o Todo é do usuário ou se o usuário é admin
        //     return response()->json(['message' => 'Forbidden'], 403);
        // }

        return response()->json($todo); 
    }

    public function store(StoreTodoRequest $request)
    {  
        $user = $request->user();

        $data = [...$request->validated(), 'user_id' => $user->id]; // valida os dados

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