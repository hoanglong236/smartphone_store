<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        $result['data'] = Category::all();
        return view('admin.category', ['admin_name'=>$admin_name, 'table_data'=>$result['data']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_category(Request $request)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        $category_data = Category::all();
        return view('admin.add_category', ['admin_name'=>$admin_name, 'category_data'=>$category_data]);
    }

    public function add_category_handle(Request $request){

        $request->validate([
            'category_name'=>'required|unique:categories',
            'category_slug'=>'required|unique:categories',
            'category_image' => 'required|mimes:jpeg,jpg,png',
        ]);

        $category = new Category();

        $category->category_name = $request->post('category_name');
        $category->category_slug = $request->post('category_slug');
        if ($request->post('category_parent_id') != "") {
            $category->category_parent_id = $request->post('category_parent_id');
        }
        else $category->category_parent_id = null;
        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $extension = $image->extension();
            $image_name = time() . '.' . $extension;
            $image->storeAs('/public/category_image/', $image_name);
            $category->category_image = $image_name;
        }
        if ($request->post('display_in_home') != null){
            $category->display_in_home = $request->post('display_in_home')[0];
        }
        
        $queryStatus = $category->save();
        if ($queryStatus > 0)
            $category_message = "Category inserted.";
        else $category_message = "Error! Insert failed.";

        $request->session()->flash('alert', $category_message);
        return redirect()->route('admin.category');
    }

    public function delete_category(Request $request, $category_id)
    {
        $category = Category::find($category_id);

        Storage::delete('/public/category_image/' . $category->category_image);
        $queryStatus = $category->delete();
        if ($queryStatus > 0)
            $category_message = "Category deleted.";
        else $category_message = "Error! Delete failed.";
        
        $request->session()->flash('alert', $category_message);
        return redirect()->route('admin.category');
    }

    public function update_category(Request $request, $category_id)
    {
        $admin_name = $request->session()->get('ADMIN_NAME');
        $category = Category::find($category_id);
        $category_data = Category::all();
        return view('admin.update_category', ['admin_name'=>$admin_name, 'category'=>$category, 'category_data'=>$category_data]);
    }

    public function update_category_handle(Request $request){

        $category_id = $request->post('id');

        if ($request->hasFile('category_image'))
            $category_image_validation = 'required|mimes:jpeg,jpg,png';
        else $category_image_validation = '';

        $request->validate([
            'category_name'=>'required|unique:categories,category_name,'.$category_id,
            'category_slug'=>'required|unique:categories,category_slug,'.$category_id,
            'category_image' => $category_image_validation,
        ]);
        
        $category = Category::where(['id'=>$category_id])->first();

        $category->category_name = $request->post('category_name');
        $category->category_slug = $request->post('category_slug');
        if ($request->post('category_parent_id') != "") {
            $category->category_parent_id = $request->post('category_parent_id');
        }
        else $category->category_parent_id = null;
        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $extension = $image->extension();
            $image_name = time() . '.' . $extension;
            $image->storeAs('/public/category_image/', $image_name);
            Storage::delete('/public/category_image/' . $category->category_image);
            $category->category_image = $image_name;
        }
        if ($request->post('display_in_home') != null){
            $category->display_in_home = $request->post('display_in_home')[0];
        }
        else $category->display_in_home = 'No';
        

        $queryStatus = $category->update();
        if ($queryStatus > 0)
            $category_message = "Category updated.";
        else $category_message = "Error! Update failed.";

        $request->session()->flash('alert', $category_message);
        return redirect()->route('admin.category');
    }

    public function change_display(Request $request, $category_id){
        $category = Category::find($category_id);
        if ($category->display_in_home == 'Yes') $category->display_in_home = 'No';
        else $category->display_in_home = 'Yes';

        $queryStatus = $category->update();
        if ($queryStatus > 0)
            $category_message = "Category Display updated.";
        else $category_message = "Error! Update failed.";
        
        $request->session()->flash('alert', $category_message);
        return redirect()->route('admin.category');
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Category  $category
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Category $category)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Category  $category
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(Category $category)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Category  $category
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, Category $category)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Category  $category
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Category $category)
    // {
    //     //
    // }
}
