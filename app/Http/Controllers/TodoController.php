<?php

namespace App\Http\Controllers;

use App\Repositories\TodoRepository;
use Illuminate\Http\Request;


class TodoController extends Controller
{
    private TodoRepository $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
        $this->middleware('auth:api');
    }

    public function index()
    {
        return $this->todoRepository->index();
    }

    public function store(Request $request)
    {
        $todoFields = $request;
        return $this->todoRepository->store($todoFields);
    }

    public function show($id)
    {
        return $this->todoRepository->show($id);
    }

    public function update(Request $request, $id)
    {
        $updatedFields = $request;
        return $this->todoRepository->update($updatedFields, $id);
    }

    public function destroy($id)
    {
        return $this->todoRepository->destroy($id);
    }

    public function trashedTodos()
    {
        return $this->todoRepository->displayTrashedTodod();
    }

    public function restoreTrashedTodo($id)
    {
        return $this->todoRepository->restoreTrashedTodos($id);
    }

    public function forceDeleteTrashedTodo($id)
    {
        return $this->todoRepository->forceDeletingTrashedTodo($id);
    }

}
