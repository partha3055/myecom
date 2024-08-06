<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        //echo ("hello");
        $result['data'] = Size::all();
        return view('admin.size', $result);
    }

    public function manage_size(Request $request, $id = '')
    {
        if ($id > 0) {
            $arr = Size::where(['id' => $id])->get();

            $result['size'] = $arr['0']->size;
            $result['id'] = $arr['0']->id;
        } else {
            $result['size'] = '';
            $result['id'] = 0;
        }
        // echo '<pre>';
        // print_r($result);
        // die();
        return view('admin.manage_size', $result);
    }

    public function manage_size_process(Request $request)
    {
        //return $request->post();
        $request->validate([
            'size' => 'required|unique:sizes,size,' . $request->post('id'),
        ]);
        if ($request->post('id')) {
            $model = Size::find($request->post('id'));
            $msg = "size updated successfully";
        } else {
            $model = new Size();
            $msg = "size created successfully";
        }

        //$model = new size();
        $model->size = $request->post('size');
        $model->status = 1;
        //dd($model);
        $model->save();
        $request->session()->flash('message', $msg);
        return redirect('admin/size');
    }


    public function delete(Request $request, $id)
    {
        //echo $id;
        $model = Size::find($id);
        $model->delete();
        $request->session()->flash('message', 'size deleted successfully');
        return redirect('admin/size');
    }

    public function status(Request $request, $type, $id)
    {
        // echo $type;
        // echo $id;
        $model = Size::find($id);
        $model->status = $type;
        $model->save();
        $request->session()->flash('message', 'size status updated');
        return redirect('admin/size');
    }
}