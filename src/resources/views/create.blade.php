<form method="POST" action="{{ route('books.store') }}">
    @csrf
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" required>
    <br>
    <label for="author">Author:</label>
    <input type="text" name="author" id="author" required>
    <br>
    <button type="submit">Add Book</button>
</form>
