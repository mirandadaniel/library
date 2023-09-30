<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexAction()
    {
        $books = Book::factory(3)->create(); 
        $response = $this->get('/'); 
        $response->assertStatus(200); 
        $response->assertViewIs('add-book-form');
        $view = $response->getOriginalContent();
        $booksInView = $view['books'];
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $booksInView);
        $found = false;
        foreach ($books as $book) {
            if ($booksInView->contains($book)) {
                $found = true;
                break;
            }
        }

        $this->assertTrue($found, 'At least one book from factory data should exist in the response');
    }

    public function testStoreAction()
    {
        $data = [
            'title' => 'Sample Book',
            'author' => 'John Doe',
        ];
        $response = $this->post(route('store-book'), $data);
        $response->assertRedirect(route('add-book-form')); 
        $this->assertDatabaseHas('books', $data); 
    }

    public function testEditAction()
    {
        $book = Book::factory()->create();
        $newTitle = 'New Title';
        $response = $this->patch(route('books.update', $book), [
            'field' => 'title',
            'value' => $newTitle,
            'bookId' => $book->id,
        ]);

        $response->assertStatus(200); 
        $this->assertEquals($newTitle, $book->fresh()->title); 
    }

    public function testEditAction2()
    {
        $book = Book::factory()->create();
        $newTitle = 'New Title2';
        $response = $this->patch(route('books.update', $book), [
            'field' => 'title',
            'value' => $newTitle,
            'bookId' => $book->id,
        ]);

        $response->assertStatus(200); 
        $this->assertEquals($newTitle, $book->fresh()->title); 
    }
    public function testEditActionAuthor()
    {
        $book = Book::factory()->create();
        $newAuthor = 'New Author';
        $response = $this->patch(route('books.update', $book), [
            'field' => 'author',
            'value' => $newAuthor,
            'bookId' => $book->id,
        ]);

        $response->assertStatus(200); 
        $this->assertEquals($newAuthor, $book->fresh()->author); 
    }

    public function testUpdateAction()
    {
        $book = Book::factory()->create();
        $data = [
            'field' => 'title', 
            'value' => 'Updated Title',
            'bookId' => $book->id,
        ];
        $response = $this->put(route('books.update', $book), $data);
        $response->assertStatus(200); 
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Updated Title',
        ]); 
    }

    public function testStoreActionFailsWhenNoTitleSpecified()
    {
        $data = [
            'author' => 'John Doe',
        ];
        $response = $this->post(route('store-book'), $data);
        $response->assertSee('The title field is required.');
        $this->assertDatabaseMissing('books', $data);
    }

    public function testStoreActionFailsWhenNoAuthorSpecified()
    {
        $data = [
            'title' => 'Peter Pan',
        ];
        $response = $this->post(route('store-book'), $data);
        $response->assertSee('The title field is required.');
        $this->assertDatabaseMissing('books', $data);
    }

    public function testDestroyAction()
    {
        $book = Book::factory()->create();
        $response = $this->delete(route('books.destroy', $book));
        $response->assertRedirect(route('add-book-form')); 
        $this->assertDatabaseMissing('books', ['id' => $book->id]); 
    }

    // public function testExportXmlAction()
    // {
    //     Book::create([
    //         'title' => 'Book 1 Title',
    //         'author' => 'Author 1',
    //     ]);

    //     Book::create([
    //         'title' => 'Book 2 Title',
    //         'author' => 'Author 2',
    //     ]);

    //     $books = Book::all();
    //     dump($books);

    //     $response = $this->get(route('export.data', [
    //         'format' => 'xml',
    //         'titles' => true,
    //         'authors' => true,
    //     ]));

    //     $response->assertStatus(200);
    //     $xmlContent = $response->getContent();
    //     $xml = simplexml_load_string($xmlContent);
    //     $this->assertNotEmpty($xml);
    //     $this->assertCount(2, $xml->book); 
    //     $this->assertEquals('Book 1 Title', (string) $xml->book[0]->title);
    //     $this->assertEquals('Author 1', (string) $xml->book[0]->author);
    // }
} 
