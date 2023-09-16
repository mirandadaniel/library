<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('books', ['books' => $books]);
       
    }
}

// class BookController extends Controller
// {
//     return view('greeting', ['name' => 'Miranda']);
// }
