<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }


    public function list()
    {
        return CategoryResource::collection(Category::all());
    }


    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function store(StoreCategoryRequest $request)
    {
            $data = $request->all();

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $name = Str::uuid() . '.' . $file->extension();
                $file->storePubliclyAs('categories', $name, 'public');
                $data['photo'] = $name;

            }
            $category = Category::create($data);
            return new CategoryResource($category);
    }

    public function update(Category $category, StoreCategoryRequest $request)
    {
        $category->update($request->all());

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        //return response()->json(null, Response::HTTP_NO_CONTENT);
        return response()->noContent();
    }
}
