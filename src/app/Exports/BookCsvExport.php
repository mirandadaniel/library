<?php

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;

class BookCsvExport implements FromCollection
{
    public function collection()
    {
        return Book::all();
    }
}