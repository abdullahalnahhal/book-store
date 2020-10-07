<?php
namespace App\Repositories;

use App\Repositories\AbstractRepository;
use Illuminate\Http\Request;
use App\Models\Book;

class BookRepository extends AbstractRepository
{

    private $repo;
    

    public function find_by(Request $request)
    {
        return $this->get($request);
    }

    public function save(Request $request, $id = null)
    {
        if ($id) {
            return $this->update($request->all(), $id);
        }
        return $this->create($request->all());
    }

    public function saveBulk($costs)
    {
        $costs = $this->model->insert($costs);
        return $costs;
    }

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Book::class;
    }
}
?>
