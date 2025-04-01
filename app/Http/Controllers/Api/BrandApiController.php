<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandApiController extends Controller
{
    public function brandList(){
        $brands = Brand::select('id','title','image')->orderbydesc('id')->get();
        return apiResponse(true,'Brands Fetch', $brands, 200);
    }
}
