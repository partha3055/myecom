<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        //echo ("hello");
        $result['data'] = Brand::all();
        return view('admin.brand', $result);
    }

    public function manage_brand(Request $request, $id = '')
    {
        if ($id > 0) {
            $arr = Brand::where(['id' => $id])->get();

            $result['brand'] = $arr['0']->brand;
            $result['bimage'] = $arr['0']->image;
            $result['is_home'] = $arr['0']->is_home;
            $result['is_home_selected'] = '';
            if ($arr['0']->is_home == 1) {
                $result['is_home_selected'] = 'checked';
            }
            $result['id'] = $arr['0']->id;
        } else {
            $result['brand'] = '';
            $result['bimage'] = '';
            $result['is_home'] = '';
            $result['is_home_selected'] = '';
            $result['id'] = 0;
        }
        // echo '<pre>';
        // print_r($result);
        // die();
        return view('admin.manage_brand', $result);
    }

    public function manage_brand_process(Request $request)
    {
        //return $request->post();
        if ($request->post('id')) {
            $image_validation = "mimes:jpeg,jpg,png,webp";
        } else {
            $image_validation = "required|mimes:jpeg,jpg,png,webp";
        }
        $request->validate([
            'brand' => 'required|unique:brands,brand,' . $request->post('id'),
            'bimage' => $image_validation,
        ]);
        if ($request->post('id')) {
            $model = Brand::find($request->post('id'));
            $msg = "brand updated successfully";
        } else {
            $model = new Brand();
            $msg = "brand created successfully";
            //dd($model);
        }

        //$model = new brand();
        if ($request->hasFile('bimage')) {

            if ($request->post('id')) {
                $brandImage = DB::table('brands')->where(['id' => $request->post('id')])->get();
                //dd($catImage[0]->category_image);
                if (Storage::exists('public/upload/brand_images/' . $brandImage[0]->image)) {
                    //dd($catImage[0]->category_image);
                    Storage::delete('public/upload/brand_images/' . $brandImage[0]->image);
                }
            }
            $image = $request->file('bimage');
            //dd($image);
            $ext = $image->extension();
            //dd($ext);
            $image_name = time() . '_brand' . '.' . $ext;
            $image->storeAs('/public/upload/brand_images/', $image_name);
            $model->image = $image_name;
        }

        $model->brand = $request->post('brand');
        $model->is_home = 0;
        if ($request->post('is_home') !== null) {
            $model->is_home = 1;
        }
        $model->status = 1;
        //dd($model);
        $model->save();
        $request->session()->flash('message', $msg);
        return redirect('admin/brand');
    }


    public function delete(Request $request, $id)
    {
        //echo $id;
        $model = Brand::find($id);
        $brandImage = DB::table('brands')->where(['id' => $id])->get();
        //dd($catImage[0]->category_image);
        if (Storage::exists('public/upload/brand_images/' . $brandImage[0]->image)) {
            //dd($catImage[0]->category_image);
            Storage::delete('public/upload/brand_images/' . $brandImage[0]->image);
        }
        $model->delete();
        $request->session()->flash('message', 'brand deleted successfully');
        return redirect('admin/brand');
    }

    public function status(Request $request, $type, $id)
    {
        // echo $type;
        // echo $id;
        $model = Brand::find($id);
        $model->status = $type;
        $model->save();
        $request->session()->flash('message', 'brand status updated');
        return redirect('admin/brand');
    }
}