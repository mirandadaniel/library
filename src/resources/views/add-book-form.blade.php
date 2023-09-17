<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-4">
    @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
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
    
    <div class="mt-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          @foreach($books as $book)
          <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author }}</td>
            <td>
            <!-- <form method="post" action="delete.php">

              <input type="text" placeholder="Enter the book ID to delete" name="getdeleteid">

              <button type="submit" value="Delete book">

              </form> -->
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>  
</body>
</html>


<!-- <!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-4">
    @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
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
    <table>
      <style>td{padding-left: 50px; border: 0.5px solid black;}</style>
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
  </div>  
</body>
</html> -->
