<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            $result['parent_category_id'] = $arr['0']->parent_category_id;
            $result['category_image'] = $arr['0']->category_image;
            $result['id'] = $arr['0']->id;

            //$result['category'] = DB::table('categories')->where(['status' => 1])->where(['id', '!=', $id])->get();
        } else {
            $result['category_name'] = '';
            $result['category_slug'] = '';
            $result['parent_category_id'] = '';
            $result['category_image'] = '';
            $result['id'] = 0;
        }

        $result['category'] = DB::table('categories')->where(['status' => 1])->get();

        // echo '<pre>';
        // print_r($result);
        // die();
        return view('admin.manage_category', $result);
    }

    public function manage_category_process(Request $request)
    {
        //return $request->post();
        if ($request->post('id')) {
            $image_validation = "mimes:jpeg,jpg,png,webp";
        } else {
            $image_validation = "required|mimes:jpeg,jpg,png,webp";
        }

        $request->validate([
            'category_name' => 'required',
            //ignore category_slug with corrospondence "$request->post('id')"->this id.
            'category_slug' => 'required|unique:categories,category_slug,' . $request->post('id'),
            'category_image' => $image_validation,
        ]);
        if ($request->post('id')) {
            $model = Category::find($request->post('id'));
            $msg = "Category updated successfully";
        } else {
            $model = new Category();
            $msg = "Category created successfully";
        }

        if ($request->hasFile('category_image')) {
            if ($request->post('id')) {
                $catImage = DB::table('categories')->where(['id' => $request->post('id')])->get();
                //dd($catImage[0]->category_image);
                if (Storage::exists('public/upload/category_images/' . $catImage[0]->category_image)) {
                    //dd($catImage[0]->category_image);
                    Storage::delete('public/upload/category_images/' . $catImage[0]->category_image);
                }
            }
            $image = $request->file('category_image');
            //dd($image);
            $ext = $image->extension();
            //dd($ext);
            $image_name = time() . '_cat_img' . '.' . $ext;
            //dd($image_name);
            $image->storeAs('/public/upload/category_images/', $image_name);
            //dd($image);
            $model->category_image = $image_name;
        }

        //$model = new Category();
        $model->category_name = $request->post('category_name');
        $model->category_slug = $request->post('category_slug');
        $model->parent_category_id = $request->post('parent_category_id');
        $model->status = 1;
        //dd($model);
        $model->save();
        $request->session()->flash('message', $msg);
        return redirect('admin/category');
    }


    public function delete(Request $request, $id)
    {
        //echo $id;
        $model = Category::find($id);
        $catImage = DB::table('categories')->where(['id' => $id])->get();
        //dd($catImage[0]->category_image);
        if (Storage::exists('public/upload/category_images/' . $catImage[0]->category_image)) {
            //dd($catImage[0]->category_image);
            Storage::delete('public/upload/category_images/' . $catImage[0]->category_image);
        }
        $model->delete();
        $request->session()->flash('message', 'Category deleted successfully');
        return redirect('admin/category');
    }

    public function status(Request $request, $type, $id)
    {
        // echo $type;
        // echo $id;
        $model = Category::find($id);
        $model->status = $type;
        $model->save();
        $request->session()->flash('message', 'Category status updated');
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