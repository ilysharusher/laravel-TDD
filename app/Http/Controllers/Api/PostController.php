<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Post\StoreRequest;
use App\Http\Requests\Api\Post\UpdateRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return PostResource::collection(Post::all())->resolve();
    }

    public function store(StoreRequest $request)
    {
        $post = Post::create($request->validated());

        return PostResource::make($post)->resolve();
    }

    public function show(Post $post)
    {
        //
    }

    public function update(UpdateRequest $request, Post $post)
    {
        $post->update($request->validated());

        return PostResource::make($post)->resolve();
    }

    public function destroy(Post $post)
    {
        //
    }
}
