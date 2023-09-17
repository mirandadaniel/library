<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('add-book-form', ['books' => $books]);
       
    }
    public function store(Request $request)
    {
        $post = new Book;
        $post->title = $request->title;
        $post->author = $request->author;
        $post->save();
        return redirect('add-book-form')->with('status', 'Book Data Has Been inserted');
    }
}

