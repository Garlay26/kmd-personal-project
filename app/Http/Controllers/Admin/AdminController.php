<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return view('admin/list', ['admins' => $admins]);
    }
    //

    public function create()
    {
        return view('admin/create');
    }

    public function store(Request $request)
    {

        $fields = $request->validate([
            'adminName' => 'required',
            'adminEmail' => 'required',
            'adminPhone' => 'required',
            'adminPassword' => 'required',
        ]);

        // Hash the password
        $fields['adminPassword'] = Hash::make($fields['adminPassword']);

        $admin = Admin::create(
            [
                'name' => $fields['adminName'],
                'email' => $fields['adminEmail'],
                'phone' => $fields['adminPhone'],
                'password' => $fields['adminPassword'],

            ]);
        return redirect()->route('admins')->with('success', "Successfully Created Admin!");

    }

    public function edit($id)
    {
        $admin = Admin::find($id);
        if ($admin) {
            return view('admin/edit', ['admin' => $admin]);
        } else {
            return redirect()->route('admins')->with('error', "Admin cannot be found!");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $fields = $request->validate([
            'adminName' => 'required',
            'adminEmail' => 'required',
            'adminPhone' => 'required',
            'id' => 'required',
        ]);

        // Hash the password
        $admin = Admin::find($fields['id']);
        if ($request->adminPassword) {
            $fields['adminPassword'] = Hash::make($request->adminPassword);
            $admin->update(
                [
                    'name' => $fields['adminName'],
                    'email' => $fields['adminEmail'],
                    'phone' => $fields['adminPhone'],
                    'password' => $fields['adminPassword'],

                ]);
        } else {
            $admin->update(
                [
                    'name' => $fields['adminName'],
                    'email' => $fields['adminEmail'],
                    'phone' => $fields['adminPhone'],
                ]);
        }

        return redirect()->route('admins')->with('success', "Successfully Updated Admin!");
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
        $admin = Admin::find($fields['delete_id']);
        $admin->delete();
        return redirect()->route('admins')->with('success', "Successfully Deleted Admin!");

    }
}
