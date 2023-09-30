<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    public function exportData(Request $request)
    {
        $format = $request->input('format', 'csv');
        $titles = $request->input('titles', false);
        $authors = $request->input('authors', false);

        if ($format === 'csv') {
            $filename = 'books.csv';
            $csvFileContents = $this->generateCSVData($titles, $authors);
            return $this->downloadFile($csvFileContents, $filename, 'text/csv');
        } elseif ($format === 'xml') {
            $filename = 'books.xml';
            $xmlFileContents = $this->generateXMLData($titles, $authors);
            return $this->downloadFile($xmlFileContents, $filename, 'application/xml');
        }
    }

    private function generateCSVData($includeTitles, $includeAuthors)
    {
        $data = [];

        if ($includeTitles && $includeAuthors) {
            $data[] = ['Title', 'Author'];
            $books = Book::all();
            foreach ($books as $book) {
                $data[] = [$book->title, $book->author];
            }
        } elseif ($includeTitles) {
            $data[] = ['Title'];
            $books = Book::all();
            foreach ($books as $book) {
                $data[] = [$book->title];
            }
        } elseif ($includeAuthors) {
            $data[] = ['Author'];
            $books = Book::all();
            foreach ($books as $book) {
                $data[] = [$book->author];
            }
        }

        return implode(PHP_EOL, array_map(function ($row) {
            return implode(',', $row);
        }, $data));
    }

    private function generateXMLData($includeTitles, $includeAuthors)
    {
        $xml = new \DOMDocument();
        $xml->formatOutput = true;

        $root = $xml->createElement('Books');
        $xml->appendChild($root);

        $books = Book::all();

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

        return $xml->saveXML();
    }

    private function downloadFile($fileContents, $filename, $contentType)
    {
        $headers = [
            'Content-Type' => $contentType,
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response($fileContents, 200, $headers);
    }

    public function generateFile(Request $request)
    {
        $format = $request->input('format', 'csv');
        $titles = $request->input('titles', false);
        $authors = $request->input('authors', false);

        if ($format === 'csv') {
            $filename = 'generated-file.csv';
            $fileContents = $this->generateCSVData($titles, $authors);
            $contentType = 'text/csv';
        } elseif ($format === 'xml') {
            $filename = 'generated-file.xml';
            $fileContents = $this->generateXMLData($titles, $authors);
            $contentType = 'application/xml';
        }

        Storage::disk('local')->put('tmp/' . $filename, $fileContents);
        $temporaryLink = Storage::disk('local')->temporaryUrl('tmp/' . $filename, now()->addMinutes(30));
        return response()->json(['download_link' => $temporaryLink]);
    }
}