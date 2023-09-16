<!-- resources/views/books/books.blade.php -->
<!DOCTYPE html>
<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $book)
            <tr>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</html>

