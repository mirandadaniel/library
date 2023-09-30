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


// namespace App\Http\Controllers;

// use App\Models\Book;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;
// // use League\Flysystem\AwsS3v3\AwsS3Adapter;

// class ExportController extends Controller
// {
//     public function exportData(Request $request)
//     {
//         $format = $request->input('format', 'csv');
//         $titles = $request->input('titles', false); 
//         $authors = $request->input('authors', false); 

//         if ($format === 'csv') {
//             $filename = 'books.csv';
//             $csvFileContents = $this->generateCSVData($titles, $authors);
//             return $this->downloadFile($csvFileContents, $filename, 'text/csv');
//         } elseif ($format === 'xml') {
//             $filename = 'books.xml';
//             $xmlFileContents = $this->generateXMLData($titles, $authors);
//             return $this->downloadFile($xmlFileContents, $filename, 'application/xml');
//         }
//     }

//     private function generateCSVData($includeTitles, $includeAuthors)
//     {
//         $data = [];

//         if ($includeTitles && $includeAuthors) {
//             $data[] = ['Title', 'Author'];
//             $books = Book::all(); // Retrieve all books
//             foreach ($books as $book) {
//                 $data[] = [$book->title, $book->author];
//             }
//         } elseif ($includeTitles) {
//             $data[] = ['Title'];
//             $books = Book::all(); // Retrieve all books
//             foreach ($books as $book) {
//                 $data[] = [$book->title];
//             }
//         } elseif ($includeAuthors) {
//             $data[] = ['Author'];
//             $books = Book::all(); // Retrieve all books
//             foreach ($books as $book) {
//                 $data[] = [$book->author];
//             }
//         }

//         return implode(PHP_EOL, array_map(function ($row) {
//             return implode(',', $row);
//         }, $data));
//     }

//     private function generateXMLData($includeTitles, $includeAuthors)
//     {
//         $xml = new \DOMDocument();
//         $xml->formatOutput = true;

//         $root = $xml->createElement('Books');
//         $xml->appendChild($root);

//         $books = Book::all(); // Retrieve all books

//         foreach ($books as $book) {
//             $bookElement = $xml->createElement('Book');
//             $root->appendChild($bookElement);

//             if ($includeTitles) {
//                 $titleElement = $xml->createElement('Title', $book->title);
//                 $bookElement->appendChild($titleElement);
//             }

//             if ($includeAuthors) {
//                 $authorElement = $xml->createElement('Author', $book->author);
//                 $bookElement->appendChild($authorElement);
//             }
//         }

//         return $xml->saveXML();
//     }

//     private function downloadFile($fileContents, $filename, $contentType)
//     {
//         // Store the file in the S3 bucket using Laravel's Storage facade
//         Storage::disk('s3')->put($filename, $fileContents);

//         // Generate a temporary URL for the S3 file
//         $temporaryUrl = Storage::disk('s3')->temporaryUrl($filename, now()->addMinutes(30));

//         // Respond with a redirect to the temporary download link
//         return redirect()->away($temporaryUrl)->withHeaders([
//             'Content-Type' => $contentType,
//             'Content-Disposition' => 'attachment; filename="' . $filename . '"',
//         ]);
//     }
//     public function generateFile(Request $request)
//     {
//         // Your file generation logic goes here, similar to the existing methods
//         $format = $request->input('format', 'csv');
//         $titles = $request->input('titles', false);
//         $authors = $request->input('authors', false);

//         if ($format === 'csv') {
//             $filename = 'generated-file.csv';
//             $fileContents = $this->generateCSVData($titles, $authors);
//             $contentType = 'text/csv';
//         } elseif ($format === 'xml') {
//             $filename = 'generated-file.xml';
//             $fileContents = $this->generateXMLData($titles, $authors);
//             $contentType = 'application/xml';
//         }

//         // Store the file in temporary storage
//         Storage::disk('local')->put('tmp/' . $filename, $fileContents);

//         // Generate a temporary download link for the file
//         $temporaryLink = Storage::disk('local')->temporaryUrl('tmp/' . $filename, now()->addMinutes(30));

//         // Respond with the download link
//         return response()->json(['download_link' => $temporaryLink]);
//     }



    // private function downloadFile($fileContents, $filename, $contentType)
    // {
    //     // Save the file to the tmp directory using Laravel's Storage facade
    //     Storage::disk('local')->put('tmp/' . $filename, $fileContents);

    //     // Generate a temporary download link for the file
    //     $temporaryLink = Storage::disk('local')->temporaryUrl('tmp/' . $filename, now()->addMinutes(30));

    //     // Respond with a redirect to the temporary download link
    //     return redirect()->away($temporaryLink)->withHeaders([
    //         'Content-Type' => $contentType,
    //         'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    //     ]);
    // }




// class ExportController extends Controller
// {

//     public function exportData(Request $request)
//     {
//         $format = $request->input('format', 'csv');
//         $titles = $request->input('titles', false);
//         $authors = $request->input('authors', false);

//         if ($format === 'csv') {
//             $filename = 'books.csv';
//             $csvFileContents = $this->generateCSVData($titles, $authors);
//             return $this->downloadFile($csvFileContents, $filename, 'text/csv');
//         } elseif ($format === 'xml') {
//             $filename = 'books.xml';
//             $xmlFileContents = $this->generateXMLData($titles, $authors);
//             return $this->downloadFile($xmlFileContents, $filename, 'application/xml');
//         }
//     }
//     // public function exportData(Request $request)
//     // {
//     //     $format = $request->input('format', 'csv');
//     //     $titles = $request->input('titles', false); 
//     //     $authors = $request->input('authors', false); 

//     //     if ($format === 'csv') {
//     //         $filename = 'books.csv';
//     //         $csvFileContents = $this->generateCSVData($titles, $authors);
//     //         return $this->downloadFile($csvFileContents, $filename, 'text/csv');
//     //     } elseif ($format === 'xml') {
//     //         $filename = 'books.xml';
//     //         $xmlFileContents = $this->generateXMLData($titles, $authors);
//     //         return $this->downloadFile($xmlFileContents, $filename, 'application/xml');
//     //     } 
//     // }

//     private function generateCSVData($includeTitles, $includeAuthors)
//     {
//         $data = [];

//         if ($includeTitles && $includeAuthors) {
//             $data[] = ['Title', 'Author'];
//             $books = Book::all(); // Retrieve all books
//             foreach ($books as $book) {
//                 $data[] = [$book->title, $book->author];
//             }
//         } elseif ($includeTitles) {
//             $data[] = ['Title'];
//             $books = Book::all(); // Retrieve all books
//             foreach ($books as $book) {
//                 $data[] = [$book->title];
//             }
//         } elseif ($includeAuthors) {
//             $data[] = ['Author'];
//             $books = Book::all(); // Retrieve all books
//             foreach ($books as $book) {
//                 $data[] = [$book->author];
//             }
//         }

//         return implode(PHP_EOL, array_map(function ($row) {
//             return implode(',', $row);
//         }, $data));
//     }

//     private function generateXMLData($includeTitles, $includeAuthors)
//     {
//         $xml = new \DOMDocument();
//         $xml->formatOutput = true;

//         $root = $xml->createElement('Books');
//         $xml->appendChild($root);

//         $books = Book::all(); // Retrieve all books

//         foreach ($books as $book) {
//             $bookElement = $xml->createElement('Book');
//             $root->appendChild($bookElement);

//             if ($includeTitles) {
//                 $titleElement = $xml->createElement('Title', $book->title);
//                 $bookElement->appendChild($titleElement);
//             }

//             if ($includeAuthors) {
//                 $authorElement = $xml->createElement('Author', $book->author);
//                 $bookElement->appendChild($authorElement);
//             }
//         }

//         $xmlData = $xml->saveXML();

//         return $xmlData;
//     }

//     private function downloadFile($fileContents, $filename, $contentType)
//     {
//         // Save the file to the tmp directory using Laravel's Storage facade
//         Storage::disk('local')->put('tmp/' . $filename, $fileContents);

//         // Generate a temporary download link for the file
//         $temporaryLink = Storage::disk('local')->temporaryUrl('tmp/' . $filename, now()->addMinutes(30));

//         // Respond with a redirect to the temporary download link
//         return redirect()->away($temporaryLink)->withHeaders([
//             'Content-Type' => $contentType,
//             'Content-Disposition' => 'attachment; filename="' . $filename . '"',
//         ]);
//     }
// }


//--------
// namespace App\Http\Controllers;

// use App\Models\Book;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Response;
// use Illuminate\Support\Facades\Storage;

// class ExportController extends Controller
// {
//     public function exportData(Request $request)
//     {
//         $format = $request->input('format', 'csv');
//         $titles = $request->input('titles', false); 
//         $authors = $request->input('authors', false); 

//         // $sortedBooks = Book::orderBy('column_name', 'asc')->get();
  
//         // if (!in_array($sortColumn, $validSortColumns)) {
//         //     return response()->json(['error' => 'Invalid sort column'], 400);
//         // }

//         $sortedBooks = Book::orderBy($sortColumn, 'asc')->get();

//         if ($format === 'csv') {
//             $filename = 'books.csv';
//             return $this->exportCSV($sortedBooks, $filename, $titles, $authors);
//         } elseif ($format === 'xml') {
//             $filename = 'books.xml';
//             return $this->exportXML($sortedBooks, $filename, $titles, $authors);
//         } 
//         // else {
//         // }
//     }

//     public function exportCSV($books, $filename, $includeTitles, $includeAuthors)
//     {
//         $data = [];

//         if ($includeTitles && $includeAuthors) {
//             $data[] = ['Title', 'Author'];
//             foreach ($books as $book) {
//                 $data[] = [$book->title, $book->author];
//             }
//         } elseif ($includeTitles) {
//             $data[] = ['Title'];
//             foreach ($books as $book) {
//                 $data[] = [$book->title];
//             }
//         } elseif ($includeAuthors) {
//             $data[] = ['Author'];
//             foreach ($books as $book) {
//                 $data[] = [$book->author];
//             }
//         }

//         $csvFileContents = implode(PHP_EOL, array_map(function ($row) {
//             return implode(',', $row);
//         }, $data));

//         $headers = [
//             'Content-Type' => 'text/csv',
//             'Content-Disposition' => 'attachment; filename="' . $filename . '"',
//         ];

//         return Response::make($csvFileContents, 200, $headers);
//     }

//     public function exportXML($books, $filename, $includeTitles, $includeAuthors)
//     {
//         $xml = new \DOMDocument();
//         $xml->formatOutput = true;

//         $root = $xml->createElement('Books');
//         $xml->appendChild($root);

//         foreach ($books as $book) {
//             $bookElement = $xml->createElement('Book');
//             $root->appendChild($bookElement);

//             if ($includeTitles) {
//                 $titleElement = $xml->createElement('Title', $book->title);
//                 $bookElement->appendChild($titleElement);
//             }

//             if ($includeAuthors) {
//                 $authorElement = $xml->createElement('Author', $book->author);
//                 $bookElement->appendChild($authorElement);
//             }
//         }

//         $xml->save($filename);

//         $headers = [
//             'Content-Type' => 'application/xml',
//             'Content-Disposition' => 'attachment; filename="' . $filename . '"',
//         ];

//         return Response::file($filename, $headers);
//     }
// }