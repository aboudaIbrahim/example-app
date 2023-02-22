<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TodoRequest;
use App\Repositories\TodoRepository;
use Illuminate\Http\Request;


class
TodoController extends Controller
{
    private TodoRepository $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
        $this->middleware('auth:api');
    }


    public function index()
    {
        //dd(Route::currentRouteName());
        return $this->todoRepository->index();
    }

    public function store(TodoRequest $request)
    {
        return $this->todoRepository->store($request);
    }

    public function show($id)
    {
        return $this->todoRepository->show($id);
    }

    public function update(TodoRequest $request, $id)
    {
        return $this->todoRepository->update($request, $id);
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
