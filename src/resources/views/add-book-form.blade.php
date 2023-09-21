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
            <th data-column="title" style="vertical-align: middle;">Title <img src="img/sort-solid.svg" alt="Sort Button" width="15" height="15" style="vertical-align: middle; cursor: pointer;"></th>
            <th data-column="author" style="vertical-align: middle;">Author <img src="img/sort-solid.svg" alt="Sort Button" width="15" height="15" style="vertical-align: middle; cursor: pointer;"></th>
            <th>Delete</th>
          </tr>
          </thead>
        <tbody id="table-content"></tbody>
        <tbody>
        @foreach($books as $book)
            <tr>
                <td>
                    <div class="editable-cell" data-field="title" data-id="{{ $book->id }}">{{ $book->title }}</div>
                </td>
                <td>
                    <div class="editable-cell" data-field="author" data-id="{{ $book->id }}">{{ $book->author }}</div>
                </td>
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
<div class="dropdown">
<button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Export as CSV
    </button>
    <div class="dropdown-menu" aria-labelledby="exportDropdown">
        <a class="dropdown-item" href="{{ route('export.titles') }}">Download Titles</a>
        <a class="dropdown-item" href="{{ route('export.authors') }}">Download Authors</a>
        <a class="dropdown-item" href="{{ route('export.csv') }}">Download Titles and Authors</a>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>
</html>