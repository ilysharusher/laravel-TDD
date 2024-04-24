<div>
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <p>{{ $post->created_at }}</p>
    <p>{{ $post->updated_at }}</p>
    <a href="{{ route('posts.edit', $post->id) }}">Edit</a>
    <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
    <a href="{{ route('posts.index') }}">Back</a>
</div>
