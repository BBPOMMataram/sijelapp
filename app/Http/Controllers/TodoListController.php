<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    public function getTodoList() {
        $todoList = TodoList::where('user_id', auth()->user()->id)->latest()->paginate(5);
        return $todoList;
    }

    function store(Request $request) {
        $todo = new TodoList();
        $todo->name = $request->name;
        $todo->user_id = $request->userId;
        $todo->save();

        return response()->json('success added!');
    }

    function update(Request $request, TodoList $todo) {
        $todo->name = $request->name;
        $todo->save();

        return response()->json('success updated!');
    }

    function setDone(Request $request, TodoList $todo) {
        $todo->isDone = filter_var($request->isDone, FILTER_VALIDATE_BOOLEAN); // UNTUK MENGKONVERSI STRING KE BOOLEAN
        $todo->save();
        
        return response()->json('isDone Updated');
    }

    function destroy(TodoList $todo){
        $todo->delete();

        return response()->json('Deleted');
    }
}
