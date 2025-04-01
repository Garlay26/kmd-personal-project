<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function productCacheClear($product)
    {
        $all = "product_" . "category_id" . "brand_id";
        $brand = "product_" . "category_id" . "brand_id" . "$product->brand_id";
        $category = "product_" . "category_id" . "$product->category_id" . "brand_id";
        $both = "product_" . "category_id" . "$product->category_id" . "brand_id" . "$product->brand_id";
        $productCount = Product::count();
        $pages = round($productCount / 12) + 1;
        for ($i = 1; $i <= $pages; $i++) {
            Cache::forget($all . "page_id$i");
            Cache::forget($brand . "page_id$i");
            Cache::forget($category . "page_id$i");
            Cache::forget($both . "page_id$i");
        }
    }
    
    public function created(Product $product)
    {
        self::productCacheClear($product);
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        self::productCacheClear($product);
    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        self::productCacheClear($product);
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        self::productCacheClear($product);
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        self::productCacheClear($product);
    }
}
