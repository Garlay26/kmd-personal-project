<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\OrderDetail;
use App\Models\ProductImage;
use Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->search)){
            $products = Product::where('name', 'like', "%$request->search%")->orderbydesc('id')->paginate(12);
        }
        else{
            $products = Product::orderbydesc('id')->paginate(12);
        }
        return view('product/list',['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select('id','title')->get();
        $brands = Brand::select('id','title')->get();
        return view('product/create',['categories' => $categories, 'brands' => $brands]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'weight' => 'required',
            'quantity' => 'required',
        ]);

        try {
            \DB::beginTransaction();
            $bar_code = generateBarcode();
            $product = Product::create([
                'name' => $fields['name'],
                'price' => $fields['price'],
                'category_id' => $fields['category_id'],
                'brand_id' => $fields['brand_id'],
                'weight' => $fields['weight'],
                'quantity' => $fields['quantity'],
                'desc' => $request->desc,
                'bar_code' => $bar_code,
            ]);
    
            $images = $request->file('images');
            foreach($images as $image){
                $photo = $image;
                $destinationPath = 'img/product';
                $image = Str::random(12) . "." . $photo->getClientOriginalExtension();
                $photo->move($destinationPath, $image);
    
                $productImage = ProductImage::create([
                    'product_id' => $product->id,
                    'image' => asset("img/product/$image"),
                ]);
            }
            \DB::commit();
            return redirect()->route('products')->with('success','Successfully Added Product!');
        } catch (\Throwable $th) {
            \DB::rollback();
            return redirect()->route('products')->with('error', "Something Went Wrong! Please Try Again Later");
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        if($product){
            $categories = Category::select('id','title')->get();
            $brands = Brand::select('id','title')->get();
            return view('product/edit',['product' => $product,'categories' => $categories, 'brands' => $brands]);
        }
        else{
            return redirect()->route('products')->with('error','Product cannot be found!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'weight' => 'required',
            'quantity' => 'required',
            'id' => 'required',
        ]);

        $product = Product::find($request->id);
        if($product){
            $product->update([
                'name' => $fields['name'],
                'price' => $fields['price'],
                'category_id' => $fields['category_id'],
                'brand_id' => $fields['brand_id'],
                'weight' => $fields['weight'],
                'quantity' => $fields['quantity'],
                'desc' => $request->desc,
            ]);
            $images = $request->file('images');
            if($images){
                $p_images = ProductImage::where('product_id',$product->id)->get();
                $p_images->map->delete();

                foreach($images as $image){
                    $photo = $image;
                    $destinationPath = 'img/product';
                    $image = Str::random(12) . "." . $photo->getClientOriginalExtension();
                    $photo->move($destinationPath, $image);
        
                    $productImage = ProductImage::create([
                        'product_id' => $product->id,
                        'image' => asset("img/product/$image"),
                    ]);
                }
            }
            return redirect()->route('products')->with('success','Successfully Updated Product!');
        }
        else{
            return redirect()->route('products')->with('error','Product cannot be found!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'delete_id' => 'required',
        ]);
        $product = Product::find($fields['delete_id']);
        if ($product) {
            $count = OrderDetail::where('product_id', $product->id)->count();
            if ($count == 0) {
                $product->delete();
                return redirect()->route('products')->with('success', "Successfully Deleted Product!");
            } else {
                return redirect()->route('products')->with('error', "Please Delete Order First!");
            }
        } else {
            return redirect()->route('products')->with('error', "Product cannot be found!");
        }
    }

    public function getProductDetail($id){
        $product = Product::find($id);
        $result = [
            'id' => $product->id,
            'name' => $product->name,
            'weight' => $product->weight,
            'price' => $product->price,
            'image' => $product->productImage->first()->image,
        ];
        return $result;
    }
}
