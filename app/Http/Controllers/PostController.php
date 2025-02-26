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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        // Create the post and assign the authenticated user's ID
        $post = $request->user()->posts()->create([
            'title' => $validated['title'],
            'content' => $validated['content']
        ]);

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
        // Check if the logged-in user is the owner of the post
        if (auth()->id() !== $post->user_id) {
            return response()->json(['message' => 'You are not authorized to delete this post.'], 403);
        }

        // If the user is the owner, proceed with the delete action
        $this->authorize('delete', $post);  // Ensure the authorization policy is checked (optional if checking manually)

        // Perform the deletion
        $post->delete();

        // Return a successful response
        return response()->json(null, 204);
    }

}