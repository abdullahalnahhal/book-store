<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Book
 * @package App\Models
 *
 * @property string name
 * @property string description
 * @property integer author_id
 *
 */
class Book extends Model
{
    use SoftDeletes;

    public $table = 'books';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'slug',
        'description',
        'author_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'slug' => 'string',
        'description' => 'string',
        'author_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:200|unique:books,name',
        'author_id' => 'required|exists:authors,id',
        'slug' => 'required|max:200|unique:authors,slug',
    ];

}
