<?php

namespace App\Http\Middleware;

use App\Models\Todolist;
use Closure;
use Illuminate\Http\Request;

class EnsureIsListMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $todolist = Todolist::find($request->route('id'));
        if (null === $todolist) {
            return response([
                "message" => "Unknown list"
            ], 404);
        }
        foreach ($todolist->users as $listUser) {
            if ($listUser->id === $user->id) {
                $request->attributes->add(['todolist' => $todolist]);
                return $next($request);
            }
        }
        return response([
            "message" => "Unauthorized"
        ], 401);
    }
}
