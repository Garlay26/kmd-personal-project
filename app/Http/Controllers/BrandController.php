<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::orderbydesc('id')->get();
        return view('brand/list',['brands' => $brands]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brand/create');
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
            'title' => 'required',
        ]);

        if ($request->file('image')) {
            $photo = $request->file('image');
            $destinationPath = 'img/brand';
            $image = Str::random(12) . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $image);

            $brand = Brand::create(
                [
                    'title' => $fields['title'],
                    'image' => asset("img/brand/$image"),
                ]
            );
        } else {
            $brand = Brand::create(
                [
                    'title' => $fields['title'],
                ]
            );
        }
        return redirect()->route('brands')->with('success', "Successfully Created Brand!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::find($id);
        if($brand){
            return view('brand/edit',['brand' => $brand]);
        }
        else{
            return redirect()->route('brands')->with('error', "Brand cannot be found!");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $fields = $request->validate([
            'title' => 'required',
            'id' => 'required',
        ]);
        $brand = Brand::find($request->id);

        if ($request->file('image')) {
            $photo = $request->file('image');
            $destinationPath = 'img/brand';
            $image = Str::random(12) . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $image);

            $brand->update(
                [
                    'title' => $fields['title'],
                    'image' => asset("img/brand/$image"),
                ]
            );
        } else {
            $brand->update(
                [
                    'title' => $fields['title'],
                ]
            );
        }

        return redirect()->route('brands')->with('success', "Successfully Updated Brand!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'delete_id' => 'required',
        ]);
        $brand = Brand::find($fields['delete_id']);
        if($brand){
            $count = Product::where('brand_id',$brand->id)->count();
            if($count == 0){
                $brand->delete();
                return redirect()->route('brands')->with('success', "Successfully Deleted Brand!");
            }
            else{
                return redirect()->route('brands')->with('error', "Please Delete Product First!");
            }
        }
        else{
            return redirect()->route('brands')->with('error', "Brand cannot be found!");
        }
    }
}
