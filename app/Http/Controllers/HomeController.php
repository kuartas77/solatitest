<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('home');
    }

    public function users(Request $request): \Illuminate\Http\JsonResponse
    {
        abort_unless($request->ajax(), 404);

        return response()->json(['data' => User::all()]);

    }

    public function show(Request $request, User $user): \Illuminate\Http\JsonResponse
    {
        abort_unless($request->ajax(), 404);

        return response()->json($user);

    }

    public function store(UserCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        abort_unless($request->ajax(), 404);
        $user = User::create($request->validated());
        return response()->json($user);
    }

    public function update(UserUpdateRequest $request, User $user): \Illuminate\Http\JsonResponse
    {
        abort_unless($request->ajax(), 404);
        $user->update($request->validated());
        return response()->json(true);
    }

    public function delete(User $user): \Illuminate\Http\RedirectResponse
    {
        $user->forceDelete();
        return back();
    }
}
