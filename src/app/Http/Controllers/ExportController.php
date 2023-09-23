<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    public function exportData(Request $request)
    {
        $format = $request->input('format', 'csv');
        $titles = $request->input('titles', false); 
        $authors = $request->input('authors', false); 

        $sortedBooks = Book::orderBy('column_name', 'asc')->get();

        if ($format === 'csv') {
            $filename = 'books.csv';
            return $this->exportCSV($sortedBooks, $filename, $titles, $authors);
        } elseif ($format === 'xml') {
            $filename = 'books.xml';
            return $this->exportXML($sortedBooks, $filename, $titles, $authors);
        } else {
        }
    }

    public function exportCSV($books, $filename, $includeTitles, $includeAuthors)
    {
        $data = [];

        if ($includeTitles && $includeAuthors) {
            $data[] = ['Title', 'Author'];
            foreach ($books as $book) {
                $data[] = [$book->title, $book->author];
            }
        } elseif ($includeTitles) {
            $data[] = ['Title'];
            foreach ($books as $book) {
                $data[] = [$book->title];
            }
        } elseif ($includeAuthors) {
            $data[] = ['Author'];
            foreach ($books as $book) {
                $data[] = [$book->author];
            }
        }

        $csvFileContents = implode(PHP_EOL, array_map(function ($row) {
            return implode(',', $row);
        }, $data));

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return Response::make($csvFileContents, 200, $headers);
    }

    public function exportXML($books, $filename, $includeTitles, $includeAuthors)
    {
        $xml = new \DOMDocument();
        $xml->formatOutput = true;

        $root = $xml->createElement('Books');
        $xml->appendChild($root);

        foreach ($books as $book) {
            $bookElement = $xml->createElement('Book');
            $root->appendChild($bookElement);

            if ($includeTitles) {
                $titleElement = $xml->createElement('Title', $book->title);
                $bookElement->appendChild($titleElement);
            }

            if ($includeAuthors) {
                $authorElement = $xml->createElement('Author', $book->author);
                $bookElement->appendChild($authorElement);
            }
        }

        $xml->save($filename);

        $headers = [
            'Content-Type' => 'application/xml',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return Response::file($filename, $headers);
    }
}