<?php

namespace App\Http\Controllers;

use App\Interfaces\RepositoryInterface;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    private RepositoryInterface $Repository;

    public function __construct(RepositoryInterface $Repository)
    {
        $this->Repository = $Repository;
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->Repository->getAll('App\Models\Product')
        );
    }

    public function filter(Request $request): JsonResponse
    {

        $data = $request->only([
            'title', 'content'
        ]);

        return response()->json(
            $this->Repository->getFulfilled($data)
        );
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $data = $this->fields($request);

        if($request->file('file')) {
            $data['file'] = $this->uploadImage($request);
        }

        return response()->json(
                $this->Repository->create($data, 'App\Models\Product'),
            Response::HTTP_CREATED
        );
    }

    public function show(Request $request): JsonResponse
    {
        $id = $request->route('product');

        return response()->json(
            $this->Repository->getById($id, 'App\Models\Product')
        );
    }

    public function update(ProductRequest $request): JsonResponse
    {
        $id = $request->route('product');

        $data = $this->fields($request);

        if($request->file('file')) {
            $data['file'] = $this->uploadImage($request);
        }

        return response()->json(
            $this->Repository->update($id, $data, 'App\Models\Product')
        );
    }

    public function destroy(ProductRequest $request): JsonResponse
    {
        $orderId = $request->route('product');
        $this->Repository->delete($orderId, 'App\Models\Product');

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function uploadImage($request) {
        $fileName = time().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('upload'), $fileName);
        return $fileName;
    }

    public function fields($request) {
        return $request->only([
            'title', 'content', 'price', 'quantity', 'category_id'
        ]);
    }

}
