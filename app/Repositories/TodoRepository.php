<?php

namespace App\Repositories;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use App\Traits\JsonResponseTrait;

class TodoRepository
{
    use JsonResponseTrait;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $todos = Todo::all();
        } catch (\Exception $exception) {
            return $this->failedRequest($exception->getMessage(), $exception->getCode());
        }
        return $this->successRequest('all todos', 200, $todos);
    }

    /**
     * @param TodoRequest $request
     * @param $todoFields
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TodoRequest $todoFields)
    {
        try {
            $todo = Todo::create([
                'title' => $todoFields->title,
                'description' => $todoFields->description,
            ]);
        } catch (\Exception $exception) {
            return $this->failedRequest($exception->getMessage(), $exception->getCode());
        }

        return $this->successRequest('todo created successfully', 200, $todo);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function show($id)
    {
        try {
            $todo = Todo::findOrFail($id);
            if (!$todo) {
                return $this->failedRequest('todo not found', 400);
            }
        } catch (\Exception $exception) {
            return $this->failedRequest($exception->getMessage(), $exception->getCode());
        }
        return $this->successRequest('todo displayed', 200, $todo);
    }

    /**
     * @param $updatedFields
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TodoRequest $updatedFields, $id)
    {
        try {
            $todo = Todo::findOrFail($id);
            $todo->title = $updatedFields->title;
            $todo->description = $updatedFields->description;
            $todo->save();
        } catch (\Exception $exception) {
            return $this->failedRequest($exception->getMessage(), $exception->getCode());
        }

        return $this->successRequest('todo updated successfully', 200, $todo);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $todo = Todo::findOrFail($id);
            if (!$todo) {
                return $this->failedRequest('todo not found', 400);
            }
            $todo->delete();
        } catch (\Exception $exception) {
            return $this->failedRequest($exception->getMessage(), $exception->getCode());
        }
        return $this->successRequest('todo soft deleted successfully', 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function displayTrashedTodos()
    {
        try {
            $trashedTodos = Todo::onlyTrashed();
        } catch (\Exception $exception) {
            return $this->failedRequest($exception->getMessage(), $exception->getCode());
        }
        return $this->successRequest('trashed todos', 200, $trashedTodos);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restoreTrashedTodos($id)
    {
        try {
            $trashedTodo = Todo::onlyTrashed()->findOrFail($id);
            if (!$trashedTodo) {
                return $this->failedRequest('no trashed todos', 400);
            }
            $trashedTodo->restore();
        } catch (\Exception $exception) {
            return $this->failedRequest($exception->getMessage(), $exception->getCode());
        }
        return $this->successRequest('todo restored', 200, $trashedTodo);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDeletingTrashedTodo($id)
    {
        try {
            $trashedTodo = Todo::onlyTrashed()->findOrFail($id);
            if (!$trashedTodo) {
                return $this->failedRequest('no trashed todos', 400);
            }
            $trashedTodo->forceDelete();
        } catch (\Exception $exception) {
            return $this->failedRequest($exception->getMessage(), $exception->getCode());
        }
        return $this->successRequest('todo restored', 200, $trashedTodo);
    }
}
