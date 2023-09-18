<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">  
</head>
<body>
<div class="container mt-4">
    <div class="card">
        <div class="card-header text-center font-weight-bold">
            Add Book
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('store-book') }}">
                @csrf
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="author">Author:</label>
                    <input type="text" name="author" id="author" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Book</button>
            </form>
        </div>
    </div>

    <div class="input-group mb-3" style="margin-top: 20px;">
      <input type="text" id="search" class="form-control" placeholder="Search for Title or Author">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button">Search</button>
      </div>
    </div>
    <div class="mt-4">
        <table class="table table-bordered">
          <thead>
          <tr>
            <th data-column="title" style="vertical-align: middle;">Title <img src="img/sort-solid.svg" alt="Image Alt Text" width="15" height="15" style="vertical-align: middle;"></th>
            <th data-column="author" style="vertical-align: middle;">Author <img src="img/sort-solid.svg" alt="Image Alt Text" width="15" height="15" style="vertical-align: middle;"></th>
            <th>Delete</th>
          </tr>
          </thead>
        <tbody id="table-content"></tbody>
            <tbody>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>
                        <form method="POST" action="{{ route('books.destroy', ['book' => $book->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn"><img src="img/trash-solid.svg" alt="Image Alt Text" width="15" height="15" style="vertical-align: middle;"></button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
<a href="{{ route('export.csv') }}" class="btn btn-primary">Export as CSV</a>
<a href="{{ route('export.xml') }}" class="btn btn-primary">Export as XML</a>
</div>
<script src="{{ asset('script.js') }}">
</script>
</body>
</html>