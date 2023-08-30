<?php

namespace App\Repositories;

use App\Http\Requests\ProductRequest;
use App\Interfaces\RepositoryInterface;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class Repository implements RepositoryInterface
{
    public function getAll($model)
    {
        return $model::all();
    }

    public function getById($id, $model)
    {
        return $model::findOrFail($id);
    }

    public function delete($id, $model)
    {
        $model::destroy($id);
    }

    public function create(array $data, $model)
    {
        return $model::create($data);
    }

    public function update($id, array $data, $model)
    {
        return $model::whereId($id)->update($data);
    }

    public function getFulfilled(array $data)
    {
        $product = new Product();
        if($data['title']) {
            $q = $product->where('title', 'like', '%'.$data['title'].'%');
        }
        if($data['content']) {
            $q = $product->where('content', 'like', '%'.$data['content'].'%');
        }
        return $q->get();
    }
}
