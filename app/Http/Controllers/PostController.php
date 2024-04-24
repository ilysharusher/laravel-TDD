<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::all(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreRequest $request)
    {
        Post::create($request->validated());
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        //
    }

    public function update(UpdateRequest $request, Post $post)
    {
        $post->update($request->validated());
    }

    public function destroy(Post $post)
    {
        $post->delete();
    }
}
