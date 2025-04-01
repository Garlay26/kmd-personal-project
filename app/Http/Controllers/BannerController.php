<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Str;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::orderbydesc('id')->get();
        return view('banner/list', ['banners' => $banners]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('banner/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->file('image')) {
            $photo = $request->file('image');
            $destinationPath = 'img/banner';
            $image = Str::random(12) . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $image);

            $banner = Banner::create(
                [
                    'link' => $request->link,
                    'image' => asset("img/banner/$image"),
                ]
            );
        } else {
            $banner = Banner::create(
                [
                    'link' => $request->link,
                ]
            );
        }
        return redirect()->route('banners')->with('success', "Successfully Created Banner!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::find($id);
        if ($banner) {
            return view('banner/edit', ['banner' => $banner]);
        } else {
            return redirect()->route('banners')->with('error', "Banner cannot be found!");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $fields = $request->validate([
            
            'id' => 'required',
        ]);
        $banner = Banner::find($request->id);

        if ($request->file('image')) {
            $photo = $request->file('image');
            $destinationPath = 'img/banner';
            $image = Str::random(12) . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $image);

            $banner->update(
                [
                    'link' => $request->link,
                    'image' => asset("img/banner/$image"),
                ]
            );
        } else {
            $banner->update(
                [
                    'link' => $request->link,
                ]
            );
        }

        return redirect()->route('banners')->with('success', "Successfully Updated Banner!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'delete_id' => 'required',
        ]);
        $banner = Banner::find($fields['delete_id']);
        if ($banner) {
            $banner->delete();
            return redirect()->route('banners')->with('success', "Successfully Deleted Banner!");
        } else {
            return redirect()->route('banners')->with('error', "Banner cannot be found!");
        }
    }
}
