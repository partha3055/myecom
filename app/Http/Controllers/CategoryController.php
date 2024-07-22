<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        //echo ("hello");
        $result['data'] = Category::all();
        return view('admin.category', $result);
    }

    public function manage_category(Request $request, $id = '')
    {
        if ($id > 0) {
            $arr = Category::where(['id' => $id])->get();

            $result['category_name'] = $arr['0']->category_name;
            $result['category_slug'] = $arr['0']->category_slug;
            $result['id'] = $arr['0']->id;
        } else {
            $result['category_name'] = '';
            $result['category_slug'] = '';
            $result['id'] = 0;
        }
        // echo '<pre>';
        // print_r($result);
        // die();
        return view('admin.manage_category', $result);
    }

    public function manage_category_process(Request $request)
    {
        //return $request->post();
        $request->validate([
            'category_name' => 'required',
            //ignore category_slug with corrospondence "$request->post('id')"->this id.
            'category_slug' => 'required|unique:categories,category_slug,' . $request->post('id'),
        ]);
        if ($request->post('id')) {
            $model = Category::find($request->post('id'));
            $msg = "Category updated successfully";
        } else {
            $model = new Category();
            $msg = "Category created successfully";
        }

        //$model = new Category();
        $model->category_name = $request->post('category_name');
        $model->category_slug = $request->post('category_slug');
        //dd($model);
        $model->save();
        $request->session()->flash('message', $msg);
        return redirect('admin/category');
    }


    public function delete(Request $request, $id)
    {
        //echo $id;
        $model = Category::find($id);
        $model->delete();
        $request->session()->flash('message', 'Category deleted successfully');
        return redirect('admin/category');
    }

    public function edit(Category $category)
    {
        //
    }

    public function update(Request $request, Category $category)
    {
        //
    }

    public function destroy(Category $category)
    {
        //
    }
}