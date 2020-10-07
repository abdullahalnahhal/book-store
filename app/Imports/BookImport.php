<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Author;
use App\Services\BookService;
use App\Services\AuthorService;
use App\Jobs\ImportFailMail;

/**
* These Classs is for Importing/Reading questionnaire excel file
* @package Questionnaire\Imports
* @method Collection collection(Collection $rows)
*/

class BookImport implements OnEachRow, WithMultipleSheets, WithChunkReading, ShouldQueue, WithEvents
{
    use Queueable, SerializesModels;

 //    public $book_service;
 //    public $author_service;

	// public function __construct(BookService $book_service, AuthorService $author_service)
	// {
	// 	$this->book_service = $book_service;
	// 	$this->author_service = $author_service;
	// }

    public function onRow(Row $row)
    {   
    	$rowIndex = $row->getIndex();
        $row      = $row->toArray();

        $author = Author::firstOrCreate([
            'name' => $row[2],
            'slug' => Str::slug($row[2])
        ]);
        
        $book = Book::firstOrCreate([
            'name' => $row[0],
            'slug' => Str::slug($row[0]),
            'description' => $row[1],
            'author_id' => $author->id,
        ]);


    	// $author = $this->author_service->findOrCreate(new Request([
    	// 	'name' => $row[2],
    	// 	'slug' => Str::slug($row[2])
    	// ]));

     //    $book = $this->book_service->findOrCreate(new Request([
     //        'name' => $row[0],
     //        'slug' => Str::slug($row[0]),
     //        'description' => $row[1],
     //        'author_id' => $author->id,
     //    ]));

        if ($book) {
            return $book;
        }
    	return null;
    }

    public function sheets(): array
    {
        return [
        	0 => $this
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function(ImportFailed $event) {
                ImportFailMail::dispatch();
            },
        ];
    }
}
