<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Post\StoreRequest;
use App\Http\Requests\Api\Post\UpdateRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
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

    public function edit(Post $post)
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
