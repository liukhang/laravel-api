<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     *
     * @var string
     */
    protected $table ='posts';
    /**
     *
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     *
     * @var array
     */
	protected $fillable = [
        'name',
    ];
}