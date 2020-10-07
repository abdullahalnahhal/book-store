<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 */
abstract class AbstractRepository
{
    
    public $model;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    abstract public function model();

    protected function conditionBuilder(Array $conditions)
    {

        $model = $this->model;
        foreach ($conditions as $key => $value) {
            if (!is_array($value)) {
                $model = $model->where($key, "=", $value);
            }elseif(isset($value['type'])){
                if($value['type'] == 'special'){
                    $model = $model->where($value['item'], $value['condition'], $value['value']);
                }elseif($value['type'] == 'null'){
                    $model = $model->whereNull($value['item'], $value['value']);
                }elseif($value['type'] == 'notNull'){
                    $model = $model->whereNotNull($value['item'], $value['value']);
                }elseif($value['type'] == 'or'){
                    $model = $model->orWhere($value['item'], $value['condition'], $value['value']);
                }elseif($value['type'] == 'whereHas'){
                    if (is_array($value)) {
                        if ($value['condition']) {
                            if ($value['anonymous']) {
                                $model = $model->whereHas($value['relation'], $value['anonymous'], $value['condition'], $value['value']);
                            }else{
                                $model = $model->whereHas($value['relation'], $value['condition'], $value['value']);
                            }
                        }else{
                            if ($value['anonymous']) {
                                $model = $model->whereHas($value['relation'], $value['anonymous']);
                            }else{
                                $model = $model->whereHas($value['relation']);
                            }
                        }
                    }else{
                        $model->whereHas($value);
                    }
                }elseif($value['type'] == 'when'){
                    if (is_array($value)) {
                        if (!$value['false']) {
                            $model = $model->when($value['item'], $value['condition']);
                        }else{
                            $model = $model->when($value['item'], $value['condition'], $value['false']);
                        }
                    }
                }
            }           
        }
        return $model;
    }

    /**
     * Make Model instance
     *
     * @return Model
     * @throws \Exception
     *
     */
    
    public function get(Request $request, $columns = ['*'], $skip = 0, $limit = 0, bool $sql = false)
    {

        $model = $this->conditionBuilder($request->all());

        if ($limit) {
            $model->limit($limit);
        }

        if ($skip) {
            $model->skip($skip);
        }

        if ($sql) {
            return $model;
        }
        return $model->get($columns);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Make Model instance
     *
     * @return Model
     * @throws \Exception
     *
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }
    
    /**
     * Create model record
     *
     * @param array $input
     *
     * @return Model
     */
    public function create($input)
    {
        if (isset($input[0]) && is_array($input[0])) {
            $model = $this->model->insert($input);
        }else{
            $model = $this->model->newInstance($input);
            $model->save();
        }
        return $model;
    }
    
    public function findOrCreate($input)
    {
        return $this->model->firstOrCreate($input);
    }

    /**
     * Update model record for given id
     *
     * @param array $input
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function update($input, $id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        $model->fill($input);

        $model->save();

        return $model;
    }
}