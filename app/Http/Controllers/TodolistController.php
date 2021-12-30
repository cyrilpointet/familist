<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    public function create(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => ['Invalid or missing fields']
            ], 400);
        }

        $todolist = Todolist::create([
            'name' => $request->name
        ]);
        $user = $request->user();
        $todolist->users()->attach($user->id);
        $todolist->users;

        return response($todolist, 200);
    }

    public function read(Request $request)
    {
        return response($request->get('todolist'), 200);
    }

    public function delete(Request $request)
    {
        $todolist = $request->get('todolist');
        $todolist->delete();
        return response([
            'message' => 'List deleted'
        ], 200);
    }
}