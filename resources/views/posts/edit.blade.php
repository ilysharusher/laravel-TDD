<div>
    <h1>Edit Post</h1>
    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ $post->title }}">
        </div>
        <div>
            <label for="content">Content</label>
            <textarea name="content" id="content" cols="30" rows="10">{{ $post->content }}</textarea>
        </div>
        <button type="submit">Update Post</button>
    </form>
    <a href="{{ route('posts.index') }}">Back</a>
</div>
