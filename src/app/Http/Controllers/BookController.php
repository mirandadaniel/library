<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Book;
use Maatwebsite\Excel\Facades\Excel;

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
        return redirect()->route('add-book-form')->with('status', 'Book Data Has Been inserted');
    }
    public function destroy($id)
    {
        // $book = Book::findOrFail($id);
        // $book->destroy();
        Book::destroy($id);
        return redirect()->route('add-book-form')->with('success', 'Book deleted successfully!');
    }
    public function exportData()
    {
        return Excel::download(new BookCsvExport, 'data.csv');
    }
}

