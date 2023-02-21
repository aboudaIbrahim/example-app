<?php

namespace App\Repositories;

use App\Models\Todo;

class TodoRepository
{

    public function index()
    {
        $todos = Todo::all();
        return response()->json([
            'status' => 'success',
            'todos' => $todos,
        ]);
    }

    public function store($todoFields)
    {
        $todoFields->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $todo = Todo::create([
            'title' => $todoFields->title,
            'description' => $todoFields->description,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Todo created successfully',
            'todo' => $todo,
        ]);
    }

    public function show($id)
    {
        $todo = Todo::find($id);
        return response()->json([
            'status' => 'success',
            'todo' => $todo,
        ]);
    }

    public function update($updatedFields, $id)
    {
        $updatedFields->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $todo = Todo::find($id);
        $todo->title = $updatedFields->title;
        $todo->description = $updatedFields->description;
        $todo->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Todo updated successfully',
            'todo' => $todo,
        ]);
    }

    public function destroy($id)
    {
        $todo = Todo::find($id);
        $todo->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Todo deleted successfully',
            'todo' => $todo,
        ]);
    }

    public function displayTrashedTodod (){
        $trashedTodos = Todo::onlyTrashed();
        return response()->json(['trashed todos' =>$trashedTodos]) ;
    }

    public function restoreTrashedTodos ($id){
        $trashedTodo = Todo::onlyTrashed()->findOrFail($id) ;
        $trashedTodo->restore();
        return response()->json(['restored todo'=>$trashedTodo]) ;
    }

    public function  forceDeletingTrashedTodo($id){
        $trashedTodo = Todo::onlyTrashed()->findOrFail($id) ;
        $trashedTodo->forceDelete();
    }
}
