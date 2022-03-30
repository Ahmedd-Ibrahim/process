<?php
namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(CategoryResource::collection(Category::parents()->paginate())->resource);
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return response()->json(new CategoryResource($category));
    }

    public function show(Category $category)
    {
        return response()->json(new CategoryResource($category));
    }

    public function update(Category $category, CategoryRequest $categoryRequest)
    {
        $category->update($categoryRequest->validated());

        return response()->json(new CategoryResource($category));
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'category Deleted succcfully']);
    }
}
