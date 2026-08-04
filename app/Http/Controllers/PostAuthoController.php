<?php

namespace App\Http\Controllers;

use App\Models\PostAutho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// ✅ Make sure this extends Controller and uses AuthorizesRequests
class PostAuthoController extends Controller
{
    public function index()
    {
        // ✅ Check authorization
        $this->authorize('viewAny', PostAutho::class);

        $posts = PostAutho::with('user')->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    public function show($id)
    {
        $post = PostAutho::findOrFail($id);
        $this->authorize('view', $post);

        return response()->json([
            'success' => true,
            'data' => $post
        ]);
    }

    public function store(Request $request)
    {
        // ✅ Check authorization
        $this->authorize('create', PostAutho::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $post = PostAutho::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'is_published' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post created!',
            'data' => $post
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $post = PostAutho::findOrFail($id);
        $this->authorize('update', $post);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string'
        ]);

        $post->update($request->only(['title', 'content']));

        return response()->json([
            'success' => true,
            'message' => 'Post updated!',
            'data' => $post
        ]);
    }

    public function destroy($id)
    {
        $post = PostAutho::findOrFail($id);
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted!'
        ]);
    }

    public function publish($id)
    {
        $post = PostAutho::findOrFail($id);
        $this->authorize('publish', $post);

        $post->update(['is_published' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Post published!',
            'data' => $post
        ]);
    }
}
