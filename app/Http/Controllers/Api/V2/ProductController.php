<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\QueryParam;

#[Group('Products', 'Managing products')]
class ProductController extends Controller
{
    #[Endpoint('Get categories', <<<DESC
        Getting the list of the products V2
        DESC)]
    #[QueryParam('page', 'int', 'Which page to show', example: 12)]
    public function index()
    {
        $products = Product::with('category')->paginate(9);

        return ProductResource::collection($products);
    }
}
