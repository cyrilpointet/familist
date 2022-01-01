<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Todolist;
use App\Models\User;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    private function populateTodolist(Todolist $todolist)
    {
        $todolist->users;
        $todolist->products;
        $todolist->invitations;
        return $todolist;
    }

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
        $todolist = $this->populateTodolist($todolist);

        return response($todolist, 200);
    }

    public function read(Request $request)
    {
        $todolist = $request->get('todolist');
        $todolist = $this->populateTodolist($todolist);
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
        $todolist = $this->populateTodolist($todolist);
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
        $todolist = $this->populateTodolist($todolist);
        if ($todolist->users()->count() < 1) {
            $todolist->delete();
            return response([
                'message' => 'No more users: list deleted'
            ], 200);
        } else {
            return response($todolist, 200);
        }
    }

    public function addInvitation(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => ['Invalid or missing fields']
            ], 400);
        }
        $todolist = $request->get('todolist');
        $invitation = Invitation::create([
            'email' => $request->email,
            'todolist_id' => $todolist->id
        ]);

        $user = $request->user();
        $details = [
            'guest' => $user->name,
        ];
        \Mail::to($request->email)->send(new \App\Mail\InvitationMail($details));

        return response($invitation, 200);
    }
}
