<?php

namespace App\Repositories;

use App\Models\Todo;
use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\Validator;

class TodoRepository
{
    use JsonResponseTrait;

    public function index()
    {
        try {
            $todos = Todo::all();
        } catch (\Exception $e) {
            return $this->failedRequest($e->getMessage(), $e->getCode());
        }
        return $this->successRequest('all todos', 200, $todos);
    }

    public function store($todoFields)
    {
        try {
            $validator = Validator::Make($todoFields->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return $this->failedRequest('invalid inputs', 400, $validator->errors);
            }
            $todo = Todo::create([
                'title' => $todoFields->title,
                'description' => $todoFields->description,
            ]);
        } catch (\Exception $e) {
            return $this->failedRequest($e->getMessage(), $e->getCode());
        }

        return $this->successRequest('todo created successfully', 200, $todo);
    }

    public function show($id)
    {
        try {
            $todo = Todo::find($id);
            if (!$todo) {
                return $this->failedRequest('todo not found', 400);
            }
        } catch (\Exception $e) {
            return $this->failedRequest($e->getMessage(), $e->getCode());
        }
        return $this->successRequest('todo displayed', 200, $todo);
    }

    public function update($updatedFields, $id)
    {
        try {
            $validator = Validator::Make($updatedFields->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
                return $this->failedRequest('invalid inputs', 400, $validator->errors());
            }
            $todo = Todo::find($id);
            if (!$todo) {
                return $this->failedRequest('todo not found', 400);
            }
            $todo->title = $updatedFields->title;
            $todo->description = $updatedFields->description;
            $todo->save();
        } catch (\Exception $e) {
            return $this->failedRequest($e->getMessage(), $e->getCode());
        }

        return $this->successRequest('todo updated successfully', 200, $todo);
    }

    public function destroy($id)
    {
        try {
            $todo = Todo::find($id);
            if (!$todo) {
                return $this->failedRequest('todo not found', 400);
            }
            $todo->delete();
        } catch (\Exception $e) {
            return $this->failedRequest($e->getMessage(), $e->getCode());
        }
        return $this->successRequest('todo soft deleted successfully', 200, $todo);
    }

    public function displayTrashedTodod()
    {
        try {
            $trashedTodos = Todo::onlyTrashed();
        } catch (\Exception $e) {
            return $this->failedRequest($e->getMessage(), $e->getCode());
        }
        return $this->successRequest('trashed todos', 200, $trashedTodos);
    }

    public function restoreTrashedTodos($id)
    {
        try {
            $trashedTodo = Todo::onlyTrashed()->findOrFail($id);
            if (!$trashedTodo) {
                return $this->failedRequest('no trashed todos', 400);
            }
            $trashedTodo->restore();
        } catch (\Exception $e) {
            return $this->failedRequest($e->getMessage(), $e->getCode());
        }
        return $this->successRequest('todo restored', 200, $trashedTodo);
    }

    public function forceDeletingTrashedTodo($id)
    {
        try {
            $trashedTodo = Todo::onlyTrashed()->findOrFail($id);
            if (!$trashedTodo) {
                return $this->failedRequest('no trashed todos', 400);
            }
            $trashedTodo->forceDelete();
        } catch (\Exception $e) {
            return $this->failedRequest($e->getMessage(), $e->getCode());
        }
        return $this->successRequest('todo restored', 200, $trashedTodo);
    }
}
