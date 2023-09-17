<?php

use App\Models\Book;
use Spatie\Export\Exportable;

class BookXmlExport
{
    use Exportable;

    public function query()
    {
        return Book::query();
    }

    public function map($book)
    {
        return [
            'title' => $book->title,
            'author' => $book->author,
        ];
    }
}
