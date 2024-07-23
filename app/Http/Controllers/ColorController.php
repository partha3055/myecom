<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        //echo ("hello");
        $result['data'] = Color::all();
        return view('admin.color', $result);
    }

    public function manage_color(Request $request, $id = '')
    {
        if ($id > 0) {
            $arr = Color::where(['id' => $id])->get();

            $result['color'] = $arr['0']->color;
            $result['id'] = $arr['0']->id;
        } else {
            $result['color'] = '';
            $result['id'] = 0;
        }
        // echo '<pre>';
        // print_r($result);
        // die();
        return view('admin.manage_color', $result);
    }

    public function manage_color_process(Request $request)
    {
        //return $request->post();
        $request->validate([
            'color' => 'required|unique:colors,color,' . $request->post('id'),
        ]);
        if ($request->post('id')) {
            $model = Color::find($request->post('id'));
            $msg = "color updated successfully";
        } else {
            $model = new Color();
            $msg = "color created successfully";
        }

        //$model = new color();
        $model->color = $request->post('color');
        $model->status = 1;
        //dd($model);
        $model->save();
        $request->session()->flash('message', $msg);
        return redirect('admin/color');
    }


    public function delete(Request $request, $id)
    {
        //echo $id;
        $model = Color::find($id);
        $model->delete();
        $request->session()->flash('message', 'color deleted successfully');
        return redirect('admin/color');
    }

    public function status(Request $request, $type, $id)
    {
        // echo $type;
        // echo $id;
        $model = Color::find($id);
        $model->status = $type;
        $model->save();
        $request->session()->flash('message', 'color status updated');
        return redirect('admin/color');
    }
}