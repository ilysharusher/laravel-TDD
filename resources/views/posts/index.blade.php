<div>
    <h1>Posts</h1>
    <ul>
        @foreach ($posts as $post)
            <li>
                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
            </li>
        @endforeach
    </ul>
    <a href="{{ route('posts.create') }}">Create Post</a>
</div>
