<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Book;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use App\Exports\BooksExport;

use App\Exports\AuthorsExport;
use App\Exports\TitlesExport;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $sortDirection = $request->input('sort', 'asc');
        $books = Book::orderBy('author', $sortDirection)->get();
        return view('add-book-form', ['books' => $books, 'sortDirection' => $sortDirection]);
    }

    public function store(Request $request)
    {
        $post = new Book;
        $post->title = $request->title;
        $post->author = $request->author;
        $post->save();
        return redirect()->route('add-book-form')->with('status', 'Book data has been inserted');
    }

    public function edit(Book $book)
    {
        return view('edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'field' => 'required|in:title,author',
            'value' => 'required|string|max:255',
            'bookId' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($validatedData['bookId']);

        if (!empty($validatedData['value'])) {
            $book->{$validatedData['field']} = $validatedData['value'];
            $book->save();

            return response()->json(['message' => 'Book updated successfully']);
        } else {
            return response()->json(['message' => 'Value cannot be blank'], 422);
        }
    }
    
    public function destroy($id)
    {
        Book::destroy($id);
        return redirect()->route('add-book-form')->with('success', 'Book deleted successfully!');
    }
}