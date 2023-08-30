<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Interfaces\RepositoryInterface;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    private RepositoryInterface $Repository;

    public function __construct(RepositoryInterface $Repository)
    {
        $this->Repository = $Repository;
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->Repository->getAll('App\Models\Category')
        );
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        $data = $this->fields($request);

        return response()->json(
            $this->Repository->create($data, 'App\Models\Category'),
            Response::HTTP_CREATED
        );
    }

    public function show(Request $request): JsonResponse
    {
        $id = $request->route('category');

        return response()->json(
            $this->Repository->getById($id, 'App\Models\Category')
        );
    }

    public function update(CategoryRequest $request): JsonResponse
    {
        $id = $request->route('category');

        $data = $this->fields($request);

        return response()->json(
            $this->Repository->update($id, $data, 'App\Models\Category')
        );
    }

    public function destroy(CategoryRequest $request): JsonResponse
    {
        $id = $request->route('product');
        $this->Repository->delete($id, 'App\Models\Category');

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function fields($request) {
        return $request->only([
            'title', 'parent_id'
        ]);
    }
}
