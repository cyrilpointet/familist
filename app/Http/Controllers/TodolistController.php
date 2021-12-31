<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use App\Models\User;
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
        $todolist->products;

        return response($todolist, 200);
    }

    public function read(Request $request)
    {
        $todolist = $request->get('todolist');
        $todolist->products;
        return response($todolist, 200);
    }

    public function delete(Request $request)
    {
        $todolist = $request->get('todolist');
        $todolist->delete();
        return response([
            'message' => 'List deleted'
        ], 200);
    }

    public function addMember(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => ['Invalid or missing fields']
            ], 400);
        }
        $newMember = User::find($request->id);
        if ($newMember === null) {
            return response([
                'message' => ['Unknown member']
            ], 404);
        }
        $todolist = $request->get('todolist');
        foreach ($todolist->users as $listUser) {
            if ($listUser->id === $request->id) {
                return response([
                    'message' => ['Already member']
                ], 400);
            }
        }
        $todolist->users()->attach($request->id);
        $todolist->save();
        $todolist->refresh();
        $todolist->users;
        $todolist->products;
        return response($todolist, 200);
    }

    public function removeMember(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => ['Invalid or missing fields']
            ], 400);
        }
        $todolist = $request->get('todolist');
        $todolist->users()->detach($request->id);
        $todolist->save();
        $todolist->refresh();
        $todolist->users;
        $todolist->products;
        return response($todolist, 200);
    }
}
