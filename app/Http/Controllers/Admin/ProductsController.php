<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductFormRequest;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductsController extends Controller
{
    protected $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getProducts()
    {
        try {
            $products = $this->repository->getAll();
            return response()->json($products, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function getProduct($id)
    {
        try {
            $product = $this->repository->findById($id);
            return response()->json($product, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function createProduct(ProductFormRequest $request)
    {
        try {
            $this->repository->store($request->all());
            return response()->json(["msg" => "Produto cadastrado"], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function deleteProduct($id)
    {
        try {
            $this->repository->delete($id);
            return response()->json(["msg" => "Produto removido"], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function updateProduct(ProductFormRequest $request, $id)
    {
        try {
            $this->repository->update($id, $request->all());
            return response()->json(["msg" => "Produto atualizado"], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
