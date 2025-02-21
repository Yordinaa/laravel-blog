<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    use AuthorizesRequests;

    public function index()
    {
        return Post::where('user_id', Auth::id())->get();
    }

    public function store(Request $request)
    {
        dd($request->user());

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $post = $request->user()->posts()->create($validated);

        return response()->json($post, 201);
    }
    public function show(Post $post)
    {
        $this->authorize('view', $post);
        return $post;
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $post->update($request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string'
        ]));
        return $post;
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return response()->json(null, 204);
    }
}