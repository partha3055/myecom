<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index()
    {
        //echo ("hello");
        $result['data'] = Customer::all();
        return view('admin.customer', $result);
    }

    public function manage_customer(Request $request, $id = '')
    {
        if ($id > 0) {
            $arr = Customer::where(['id' => $id])->get();

            $result['customer_list'] = $arr['0'];
            //dd($result['customer_list']);
            // $result['email'] = $arr['0']->email;
            // $result['mobile'] = $arr['0']->mobile;
            // $result['password'] = $arr['0']->password;
            // $result['address'] = $arr['0']->address;
            // $result['city'] = $arr['0']->city;
            // $result['state'] = $arr['0']->state;
            // $result['zip'] = $arr['0']->zip;
            // $result['company'] = $arr['0']->company;
            // $result['gstin'] = $arr['0']->gstin;
            // $result['id'] = $arr['0']->id;

            //$result['customer'] = DB::table('customers')->where(['status' => 1])->where(['id', '!=', $id])->get();
        }
        //else {
        //     $result['name'] = '';
        //     $result['email'] = '';
        //     $result['mobile'] = '';
        //     $result['password'] = '';
        //     $result['address'] = '';
        //     $result['city'] = '';
        //     $result['state'] = '';
        //     $result['zip'] = '';
        //     $result['company'] = '';
        //     $result['gstin'] = '';
        //     $result['id'] = 0;
        // }

        //$result['customer'] = DB::table('customers')->where(['status' => 1])->get();

        // echo '<pre>';
        // print_r($result);
        // die();
        return view('admin.manage_customer', $result);
    }

    // public function manage_customer_process(Request $request)
    // {
    //     //return $request->post();
    //     // if ($request->post('id')) {
    //     //     $image_validation = "mimes:jpeg,jpg,png,webp";
    //     // } else {
    //     //     $image_validation = "required|mimes:jpeg,jpg,png,webp";
    //     // }

    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|unique:customers,email,' . $request->post('id'),
    //         // 'customer_slug' => 'required|unique:customers,customer_slug,' . $request->post('id'),
    //         // 'customer_image' => $image_validation,
    //     ]);
    //     if ($request->post('id')) {
    //         $model = Customer::find($request->post('id'));
    //         $msg = "Customer Updated Successfully";
    //     } else {
    //         $model = new customer();
    //         $msg = "Customer Created Successfully";
    //     }

    //     // if ($request->hasFile('customer_image')) {
    //     //     if ($request->post('id')) {
    //     //         $catImage = DB::table('customers')->where(['id' => $request->post('id')])->get();
    //     //         //dd($catImage[0]->customer_image);
    //     //         if (Storage::exists('public/upload/customer_images/' . $catImage[0]->customer_image)) {
    //     //             //dd($catImage[0]->customer_image);
    //     //             Storage::delete('public/upload/customer_images/' . $catImage[0]->customer_image);
    //     //         }
    //     //     }
    //     //     $image = $request->file('customer_image');
    //     //     //dd($image);
    //     //     $ext = $image->extension();
    //     //     //dd($ext);
    //     //     $image_name = time() . '_cat_img' . '.' . $ext;
    //     //     //dd($image_name);
    //     //     $image->storeAs('/public/upload/customer_images/', $image_name);
    //     //     //dd($image);
    //     //     $model->customer_image = $image_name;
    //     // }

    //     //$model = new customer();
    //     $model->name = $request->post('name');
    //     $model->email = $request->post('email');
    //     $model->mobile = $request->post('mobile');
    //     $model->mobile = $request->post('mobile');
    //     $model->password = $request->post('password');
    //     $model->address = $request->post('address');
    //     $model->city = $request->post('city');
    //     $model->state = $request->post('state');
    //     $model->zip = $request->post('zip');
    //     $model->company = $request->post('company');
    //     $model->gstin = $request->post('gstin');
    //     $model->status = 1;
    //     //dd($model);
    //     $model->save();
    //     $request->session()->flash('message', $msg);
    //     return redirect('admin/customer');
    // }


    // public function delete(Request $request, $id)
    // {
    //     //echo $id;
    //     $model = Customer::find($id);
    //     // $catImage = DB::table('customers')->where(['id' => $id])->get();
    //     // //dd($catImage[0]->customer_image);
    //     // if (Storage::exists('public/upload/customer_images/' . $catImage[0]->customer_image)) {
    //     //     //dd($catImage[0]->customer_image);
    //     //     Storage::delete('public/upload/customer_images/' . $catImage[0]->customer_image);
    //     // }
    //     $model->delete();
    //     $request->session()->flash('message', 'Customer Deleted Successfully');
    //     return redirect('admin/customer');
    // }

    public function status(Request $request, $type, $id)
    {
        // echo $type;
        // echo $id;
        $model = Customer::find($id);
        $model->status = $type;
        $model->save();
        $request->session()->flash('message', 'Customer Status Updated');
        return redirect('admin/customer');
    }
}