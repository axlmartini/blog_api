<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index()
    {
        return Post::with('comments')->get();
    }

    public function show(Post $post)
    {
        return Post::with('comments')->find($post->id);
    }

    public function store(Request $request)
    {
        $post = Post::create($request->all());
        return response()->json($post, 201);
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());

        return response()->json($post, 200);
    }

    public function delete(Request $request, Post $post)
    {
        $postComments = $post->comments()->get();
        if (0 === sizeof($postComments)) {
            $post->delete();
            $result = [
                'message' => 'Record has been deleted.'
            ];
        } else {
            $result = [
                'message' => 'Cannot delete record. Associated with Comment.'
            ];
        }

        return response()->json($result, 200);
    }
}
