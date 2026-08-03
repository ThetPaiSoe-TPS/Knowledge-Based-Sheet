<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'comments.user'])->published()->recent()->get()->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'content' => $post->content,
                'created_at' => $post->created_at->diffForHumans(),
                'author' => [
                    'id' => $post->user->id,
                    'name' => $post->user->name,
                    'email' => $post->user->email,
                ],
                'comments_count' => $post->comments()->count(),
                'comments' => $post->comments->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'content' => $comment->content,
                        'user' => $comment->user->name,
                        'created_at' => $comment->created_at->diffForHumans(),
                        'is_approved' => $comment->is_approved,
                    ];
                }),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $posts,
            'total' => $posts->count(),
        ]);
    }

    public function show($id)
    {
        $post = Post::with(['user', 'comments.user'])
            ->find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'post' => $post,
                'author' => $post->user,
                'comments' => $post->comments,
                'comments_count' => $post->comments()->count(),
                'approved_comments_count' => $post->approvedComments()->count(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id', // Validate foreign key exists
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_published' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $slug = Str::slug($request->title);

        $count = Post::where('slug', 'LIKE', $slug . '%')->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        $post = Post::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $slug,
            'is_published' => $request->is_published ?? false,
        ]);

        $post->load('user');

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully',
            'data' => $post,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'is_published' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $updateData = [];

        if ($request->has('title')) {
            $updateData['title'] = $request->title;

            if ($request->title !== $post->title) {
                $slug = Str::slug($request->title);
                $count = Post::where('slug', 'LIKE', $slug . '%')->where('id', '!=', $id)->count();
                if ($count > 0) {
                    $slug = $slug . ' - ' . ($count + 1);
                }
                $updateData['slug'] = $slug;
            }
        }

        if ($request->has('content')) {
            $updateData['content'] = $request->content;
        }

        if ($request->has('is_published')) {
            $updateData['is_published'] = $request->is_published;
        }

        if (empty($updateData)) {
            return response()->json([
                'success' => false,
                'message' => 'No data to update'
            ], 422);
        }

        $post->update($updateData);

        $post->load('user');

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully',
            'data' => $post,
        ]);
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post and all its comments deleted successfully',
        ]);
    }

    public function getPostsByUser($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $posts = Post::with('user')
            ->where('user_id', $userId)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'posts_count' => $posts->count(),
                'posts' => $posts,
            ],
        ]);
    }
}
