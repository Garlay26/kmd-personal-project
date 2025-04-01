<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderbydesc('id')->get();
        return view('category/list', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category/create');
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
            $destinationPath = 'img/category';
            $image = Str::random(12) . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $image);

            $category = Category::create(
                [
                    'title' => $fields['title'],
                    'image' => asset("img/category/$image"),
                ]
            );
        } else {
            $category = Category::create(
                [
                    'title' => $fields['title'],
                ]
            );
        }
        return redirect()->route('categories')->with('success', "Successfully Created Category!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        if ($category) {
            return view('category/edit', ['category' => $category]);
        } else {
            return redirect()->route('categories')->with('error', "Category cannot be found!");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $fields = $request->validate([
            'title' => 'required',
            'id' => 'required',
        ]);
        $category = Category::find($request->id);

        if ($request->file('image')) {
            $photo = $request->file('image');
            $destinationPath = 'img/category';
            $image = Str::random(12) . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $image);

            $category->update(
                [
                    'title' => $fields['title'],
                    'image' => asset("img/category/$image"),
                ]
            );
        } else {
            $category->update(
                [
                    'title' => $fields['title'],
                ]
            );
        }

        return redirect()->route('categories')->with('success', "Successfully Updated Category!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'delete_id' => 'required',
        ]);
        $category = Category::find($fields['delete_id']);
        if ($category) {
            $count = Product::where('category_id', $category->id)->count();
            if ($count == 0) {
                $category->delete();
                return redirect()->route('categories')->with('success', "Successfully Deleted Category!");
            } else {
                return redirect()->route('categories')->with('error', "Please Delete Product First!");
            }
        } else {
            return redirect()->route('categories')->with('error', "Category cannot be found!");
        }
    }
}
