<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\AuthorRepository;


class AuthorService
{

    private $repo;
    
    public function __construct(AuthorRepository $repo)
    {
        $this->repo = $repo;
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
     * @return Boolean
     */
    public function save(Request $request, $id = null)
    {
        $item = $this->repo->save($request, $id);

        return $item;
    }

    public function findOrCreate(Request $request)
    {
        $item = $this->repo->findOrCreate($request->all());
        return $item;
    }
}
?>
