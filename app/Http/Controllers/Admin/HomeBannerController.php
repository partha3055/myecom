<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\HomeBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeBannerController extends Controller
{
    public function index()
    {
        //echo ("hello");
        $result['data'] = HomeBanner::all();
        return view('admin.homebanner', $result);
    }

    public function manage_homebanner(Request $request, $id = '')
    {
        if ($id > 0) {
            $arr = HomeBanner::where(['id' => $id])->get();

            $result['image'] = $arr['0']->image;
            $result['btn_text'] = $arr['0']->btn_text;
            $result['btn_link'] = $arr['0']->btn_link;
            // $result['is_home_selected'] = '';
            // if ($arr['0']->is_home == 1) {
            //     $result['is_home_selected'] = 'checked';
            // }
            $result['id'] = $arr['0']->id;
        } else {
            $result['image'] = '';
            $result['btn_text'] = '';
            $result['btn_link'] = '';
            //$result['is_home_selected'] = '';
            $result['id'] = 0;
        }
        // echo '<pre>';
        // print_r($result);
        // die();
        return view('admin.manage_homebanner', $result);
    }

    public function manage_homebanner_process(Request $request)
    {
        //return $request->post();
        if ($request->post('id')) {
            $image_validation = "mimes:jpeg,jpg,png,webp";
        } else {
            $image_validation = "required|mimes:jpeg,jpg,png,webp";
        }
        $request->validate([
            'image' => $image_validation
        ]);
        if ($request->post('id')) {
            $model = HomeBanner::find($request->post('id'));
            $msg = "Home Banner Updated Successfully";
        } else {
            $model = new HomeBanner();
            $msg = "Home Banner Created Successfully";
            //dd($model);
        }

        //$model = new homebanner();
        if ($request->hasFile('image')) {

            if ($request->post('id')) {
                $homebannerImage = DB::table('home_banners')->where(['id' => $request->post('id')])->get();
                //dd($catImage[0]->category_image);
                if (Storage::exists('public/upload/homebanner_images/' . $homebannerImage[0]->image)) {
                    //dd($catImage[0]->category_image);
                    Storage::delete('public/upload/homebanner_images/' . $homebannerImage[0]->image);
                }
            }
            $image = $request->file('image');
            $ext = $image->extension();
            $image_name = time() . '_homebanner' . '.' . $ext;
            $image->storeAs('/public/upload/homebanner_images/', $image_name);
            $model->image = $image_name;
        }

        $model->btn_text = $request->post('btn_text');
        $model->btn_link = $request->post('btn_link');
        // $model->is_home = 0;
        // if ($request->post('is_home') !== null) {
        //     $model->is_home = 1;
        // }
        $model->status = 1;
        //dd($model);
        $model->save();
        $request->session()->flash('message', $msg);
        return redirect('admin/homebanner');
    }


    public function delete(Request $request, $id)
    {
        //echo $id;
        $model = HomeBanner::find($id);
        $homebannerImage = DB::table('home_banners')->where(['id' => $id])->get();
        //dd($catImage[0]->category_image);
        if (Storage::exists('public/upload/homebanner_images/' . $homebannerImage[0]->image)) {
            //dd($catImage[0]->category_image);
            Storage::delete('public/upload/homebanner_images/' . $homebannerImage[0]->image);
        }
        $model->delete();
        $request->session()->flash('message', 'Home Banner Deleted Successfully');
        return redirect('admin/homebanner');
    }

    public function status(Request $request, $type, $id)
    {
        // echo $type;
        // echo $id;
        $model = HomeBanner::find($id);
        $model->status = $type;
        $model->save();
        $request->session()->flash('message', 'Home Banner Status Updated');
        return redirect('admin/homebanner');
    }
}