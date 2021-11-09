<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        // get data table post
        $post = Post::latest()->get();

        // make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Post',
            'data' => $post
        ], 200);
    }


    public function show($id)
    {
        // find post by ID
        $post = Post::findOrFail($id);

        // make response JSON
        return response()->json([
            'succes' => true,
            'message' => 'Detail Data Post',
            'data' => $post
        ], 200);
    }


    public function store(Request $request)
    {
        // set Validation
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);

        // response error validation
        if($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        // save to database
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content
        ]);

        // succes save to database
        if($post) {
            return response()->json([
                'succes' => true,
                'message' => 'Post Create',
                'data' => $post
            ], 201);
        }

        // failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Post Failed to Save'
        ], 409);
    }


    public function update(Request $request, Post $post)
    {
        // set Validation
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);

        // response error validation
        if($validate->fails()) {
            return response()->json($validate->errors(), 409);
        }

        // find post by ID
        $post = Post::findOrFail($post->id);

        if($post) {
            // update Post
            $post->update([
                'title' => $request->title,
                'content' => $request->content
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $post
            ], 200);
        }

        // data post not found
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);
    }


    public function destroy($id)
    {
        // find post by ID
        $post = Post::findOrFail($id);

        if($post) {
            // delete post
            $post->delete();

            return response()->json([
                'success' =>true,
                'message' => 'Post Deleted'
            ], 200);
        }

        // data post not found
        return response()->json([
            'message' => false,
            'message' => 'Post Not Found'
        ], 200);
    }
}
