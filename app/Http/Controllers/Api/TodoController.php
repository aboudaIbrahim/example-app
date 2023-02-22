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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //dd(Route::currentRouteName());
        return $this->todoRepository->index();
    }

    /**
     * @param TodoRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TodoRequest $request)
    {
        return $this->todoRepository->store($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->todoRepository->show($id);
    }

    /**
     * @param TodoRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TodoRequest $request, $id)
    {
        return $this->todoRepository->update($request, $id);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->todoRepository->destroy($id);
    }

    /**
     * @return mixed
     */
    public function trashedTodos()
    {
        return $this->todoRepository->displayTrashedTodod();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restoreTrashedTodo($id)
    {
        return $this->todoRepository->restoreTrashedTodos($id);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDeleteTrashedTodo($id)
    {
        return $this->todoRepository->forceDeletingTrashedTodo($id);
    }

}
