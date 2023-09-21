@section('content')
<div class="container">
    <h2>Edit Book</h2>
    <form method="POST" action="{{ route('books.update', ['book' => $book->id]) }}">
        @csrf
        @method('PUT') {{-- Use the PUT method for updating --}}
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $book->title }}" required>
        </div>
        <div class="form-group">
            <label for="author">Author:</label>
            <input type="text" name="author" id="author" class="form-control" value="{{ $book->author }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Book</button>
    </form>
</div>
@endsection
