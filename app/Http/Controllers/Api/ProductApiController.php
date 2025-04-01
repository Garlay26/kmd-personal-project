<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductApiController extends Controller
{
    public function productList(request $request)
    {
        $cacheName = "product_"."category_id"."$request->category_id"."brand_id"."$request->brand_id"."page_id"."$request->page";
        if (Cache::has($cacheName)) {
            $products = Cache::get($cacheName);
            return apiResponse(true, 'Products Fetch from cache', $products, 200);
        } else {
            $products = Product::when(!empty($request->category_id), function ($query) use ($request) {
                return $query->where('category_id', $request->category_id);
            })
                ->when(!empty($request->brand_id), function ($query) use ($request) {
                    return $query->where('brand_id', $request->brand_id);
                })
                ->with('category', 'brand', 'productImage')
                ->orderbydesc('id')
                ->paginate(12);
            Cache::forever($cacheName, $products);
            return apiResponse(true, 'Products Fetch From Database', $products, 200);
        }
    }

    public function search(Request $request){
        if($request->search){
            $products = Product::where('name', 'like', '%' . $request->search . '%')
                                ->with('category', 'brand', 'productImage')
                                ->orderbydesc('id')
                                ->paginate(12);
        }
        else{
            $products = Product::with('category', 'brand', 'productImage')->orderbydesc('id')->paginate(12);
        }
        return apiResponse(true, 'Products Fetch', $products, 200);
    }
}
