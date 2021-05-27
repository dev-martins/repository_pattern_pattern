<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUpdateCategory;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoriesController extends Controller
{
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getCategories()
    {
        try {
            $categories = $this->repository->getAll();
            return response()->json($categories, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function getCategory($id)
    {
        try {
            $category = $this->repository->findById($id);
            return response()->json($category, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function searchCategory(Request $request)
    {
        try {
            $categories = $this->repository->search($request->all());
            return response()->json($categories, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function createCategory(CreateUpdateCategory $request)
    {
        try {
            $this->repository->store($request->input());
            return response()->json(['msg' => 'Categoria cadastrada'], 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function deleteCategory($id)
    {
        try {
            if ($this->repository->productsByCategory($id) > 0) {
                $this->repository->delete($id);
                return response()->json([], 200);
            } else {
                return response()->json(['msg' => 'Categoria contém produtos vinculados!'], 403);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function updateCategory(CreateUpdateCategory $request, $id)
    {
        try {
            $this->repository->update($id, $request->input());
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
