<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    public function categoryList(){
        $categories = Category::select('id','title','image')->orderbydesc('id')->get();
        return apiResponse(true,'Category Fetch', $categories, 200);
    }
}
