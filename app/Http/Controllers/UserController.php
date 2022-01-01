<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            return response([
                'message' => $validator->errors()
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $invitations = Invitation::where('email', $user->email)->get();
        foreach ($invitations as $invitation) {
            $user->todolists()->attach($invitation->todolist_id);
            $invitation->delete();
        }
        $user->todolists;

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['user' => $user,'token' => $token, ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        $user->todolists;

        return response()
            ->json(['user' => $user,'token' => $token, ]);
    }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }

    public function show(Request $request)
    {
        $user = $request->user();
        $user->todolists;
        return response($user, 200);
    }

    public function findByEmail(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => ['Invalid or missing fields']
            ], 400);
        }
        $user = User::where('email', '=', $request->email)->first();
        if (null === $user) {
            return response([
                'message' => ['No such user']
            ], 404);
        }
        return response($user, 200);
    }
}
