<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookService;
use App\Http\Requests\CreateBookPluckRequest;

class BookController extends Controller
{
    private $service;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BookService $service)
    {
        $this->service = $service;
    }

    public function storePluck(CreateBookPluckRequest $request)
    {
        $file = $request->file->store('public');
        $save = $this->service->savePluck(new Request([
            'file' => 'storage/'.basename($file),
        ]));
        return back();
    }
}
