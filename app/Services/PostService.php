<?php
namespace App\Services;


use App\Models\Post;
use App\Http\Controllers\Controller;

class PostService
{
    public function save(array $data, int $id = null)
    {
        return Post::updateOrCreate(
            [
                'id' => $id,
            ],
            [
                'name' => $data['name'],
            ]
        );
    }

    public function getAll($orderBys = [], $limit = 10)
    {
        $query = Post::query();

        if ($orderBys) {
            $query->orderBy($orderBys['column'], $orderBys['sort']);
        }
        return $query->paginate($limit);
    }

    public function findByID($id)
    {
        return Post::find($id);
    }

    public function delete($ids = [])
    {
        return Post::destroy($ids);
    }
}