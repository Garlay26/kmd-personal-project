<?php

namespace App\Http\Controllers\Api;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerApiController extends Controller
{
    public function bannerList(){
        $banners = Banner::select('id','link','image')->orderbydesc('id')->get();
        return apiResponse(true,'Banners Fetch', $banners, 200);
    }
}
