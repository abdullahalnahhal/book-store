<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\BookRepository;
use App\Services\AuthorService;
use App\Imports\BookImport;
use App\Jobs\ImportCompleteMail;
use Excel;

class BookService
{

    private $repo;
    
    public function __construct(BookRepository $repo, AuthorService $author_service)
    {
        $this->repo = $repo;
        $this->author_service = $author_service;
    }

    /**
     * Use Search Criteria from request to find from Repository
     *
     * @param  Request $request
     * @return Collection
     */
    public function find_by(Request $request)
    {
        $item = $this->repo->find_by($request);
        return $item;
    }
    /**
     * Use id to find from Repository
     *
     * @param  Int $id
     * @return Company
     */
    public function find($id)
    {
        $item = $this->repo->find($id);
        return $item;
    }
    /**
     * Use save data into Repository
     *
     * @param  Request $request
     * @param  Int $id
     * @return BooleanApp\Imports;
     */
    public function save(Request $request, $id = null)
    {
        $item = $this->repo->save($request, $id);

        return $item;
    }

    public function savePluck(Request $request)
    {
        $import = new BookImport($this, $this->author_service);
        // get the first sheet rows
        Excel::queueImport($import, $request->file)->chain([
            new ImportCompleteMail()
        ]);

        
    }
}
?>
