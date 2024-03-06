<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TodoModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$todos = TodoModel::all();
        $todos = TodoModel::where('user_id', Auth::user()->id)->get();
        return view('todo/todos-list', compact('todos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('todo.index')->withErrors($validator);
        }

        $userId = Auth::user()->id;
        $user = User::find($userId);
        $todoData = [
            'title' => $request->get('title')
        ];
        $post = new TodoModel($todoData);
        $post->user()->associate($user);
        $post->save();

        return redirect()->route('todo.index')->with('success', 'Todo inserted');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $todo = TodoModel::where('id', $id)->first();
        return view('todo/edit-todo', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('todo.edit')->withErrors($validator);
        };

        $todo = TodoModel::where('id', $id)->first();
        $todo->title = $request->get('title');
        $todo->is_completed = $request->get('is_completed');
        $todo->save();

        return redirect()->route('todo.index')->with('success', 'Todo Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        TodoModel::where('id', $id)->delete();

        return redirect()->route('todo.index')->with('success', 'TodoDeleted');
    }
}
