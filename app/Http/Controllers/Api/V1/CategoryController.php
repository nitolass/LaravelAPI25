<?php

    namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * @group Categories
 *
 * Managing Categories
 *
 * @queryParam page Which page to show. Example: 12
 */
class CategoryController extends Controller
{
    /**
     * Get Categories
     *
     * Getting the list of the categories
     */
    public function index()
    {
        abort_if(! auth()->user()->tokenCan('categories-list'), 403);

        return CategoryResource::collection(Cache::remember('categories', 60*60*24, function () {
            return Category::where('id', '>', 5)->get();
        }));    }

    public function list()
    {
        return CategoryResource::collection(Category::all());
    }

    public function show(Category $category)
    {
        //abort_if(! auth()->user()->tokenCan('categories-show'), 403);

        return new CategoryResource($category);
    }

    /**
     * POST categories
     *
     * @bodyParam name string required Name of the category. Example "Clothing"
     * @bodyParam description nullable Description of the category.
     */
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

    public function destroy(Category $category) {
        $category->delete();

        //return response()->json(null, Response::HTTP_NO_CONTENT);
        return response()->noContent();
    }
}
