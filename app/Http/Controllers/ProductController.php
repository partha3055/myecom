<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        //echo ("hello");
        $result['data'] = Product::all();
        return view('admin.product', $result);
    }

    public function manage_product(Request $request, $id = '')
    {
        if ($id > 0) {
            $arr = Product::where(['id' => $id])->get();

            $result['category_id'] = $arr['0']->category_id;
            $result['name'] = $arr['0']->name;
            $result['image'] = $arr['0']->image;
            $result['slug'] = $arr['0']->slug;
            $result['brand_id'] = $arr['0']->brand_id;
            $result['model'] = $arr['0']->model;
            $result['short_desc'] = $arr['0']->short_desc;
            $result['desc'] = $arr['0']->desc;
            $result['keywords'] = $arr['0']->keywords;
            $result['technical_specification'] = $arr['0']->technical_specification;
            $result['uses'] = $arr['0']->uses;
            $result['warranty'] = $arr['0']->warranty;
            $result['id'] = $arr['0']->id;

            $result['ProductAttrArr'] = DB::table('products_attr')->where(['product_id' => $id])->get();
            $ProductImages = DB::table('product_images')->where(['product_id' => $id])->get();

            //dd($ProductImages);

            if (!isset($ProductImages[0])) {
                $result['ProductImages']['0']['id'] = '';
                $result['ProductImages']['0']['image'] = '';
            } else {
                $result['ProductImages'] = $ProductImages;
            }

            //dd($result['ProductImages']);
        } else {
            $result['category_id'] = '';
            $result['name'] = '';
            $result['image'] = '';
            $result['slug'] = '';
            $result['brand_id'] = '';
            $result['model'] = '';
            $result['short_desc'] = '';
            $result['desc'] = '';
            $result['keywords'] = '';
            $result['technical_specification'] = '';
            $result['uses'] = '';
            $result['warranty'] = '';
            $result['id'] = 0;

            $result['ProductAttrArr'][0]['id'] = '';
            $result['ProductAttrArr'][0]['product_id'] = '';
            $result['ProductAttrArr'][0]['size_id'] = '';
            $result['ProductAttrArr'][0]['color_id'] = '';
            $result['ProductAttrArr'][0]['sku'] = '';
            $result['ProductAttrArr'][0]['attr_image'] = '';
            $result['ProductAttrArr'][0]['mrp'] = '';
            $result['ProductAttrArr'][0]['price'] = '';
            $result['ProductAttrArr'][0]['qty'] = '';

            $result['ProductImages']['0']['id'] = '';
            $result['ProductImages']['0']['image'] = '';
        }
        // echo '<pre>';
        // print_r($result);
        // die();

        $result['category'] = DB::table('categories')->where(['status' => 1])->get();
        $result['size'] = DB::table('sizes')->where(['status' => 1])->get();
        $result['color'] = DB::table('colors')->where(['status' => 1])->get();
        $result['brand'] = DB::table('brands')->where(['status' => 1])->get();

        // echo '<pre>';
        // print_r($result);
        // die();
        return view('admin.manage_product', $result);
    }

    public function manage_product_process(Request $request)
    {
        //return $request->post();
        // echo '<pre>';
        // print_r($request->post());
        // die();

        if ($request->post('id')) {
            $image_validation = "mimes:jpeg,jpg,png,webp";
        } else {
            $image_validation = "required|mimes:jpeg,jpg,png,webp";
        }
        $request->validate([
            'name' => 'required',
            'image' => $image_validation,
            'slug' => 'required|unique:products,slug,' . $request->post('id'),
            'attr_image.*' => "mimes:jpeg,jpg,png,webp",
            'images.*' => "mimes:jpeg,jpg,png,webp",
        ]);

        $pAttr = $request->post('pattr_id');
        $skuAttr = $request->post('sku');
        $mrpAttr = $request->post('mrp');
        //dd($mrpAttr);
        $priceAttr = $request->post('price');
        $qtyAttr = $request->post('qty');
        $size_idAttr = $request->post('size_id');
        $color_idAttr = $request->post('color_id');

        foreach ($skuAttr as $key => $value) {
            $check = DB::table('products_attr')->where('sku', '=', $skuAttr[$key])->where('id', '!=', $pAttr[$key])->get();
            if (isset($check[0])) {
                $request->session()->flash('sku_error', $skuAttr[$key] . ' SKU is already used');
                return redirect(request()->headers->get('referer'));
            }
        }

        if ($request->post('id')) {
            $model = Product::find($request->post('id'));
            $msg = "product updated successfully";
        } else {
            $model = new Product();
            $msg = "product created successfully";
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            //dd($image);
            $ext = $image->extension();
            //dd($ext);
            $image_name = time() . '.' . $ext;
            $image->move('upload', $image_name);
            $model->image = $image_name;
        }

        //$model = new product();
        $model->category_id = $request->post('category_id');
        $model->name = $request->post('name');
        //$model->image = $request->post('image');
        $model->slug = $request->post('slug');
        $model->brand_id = $request->post('brand_id');
        $model->model = $request->post('model');
        $model->short_desc = $request->post('short_desc');
        $model->desc = $request->post('desc');
        $model->keywords = $request->post('keywords');
        $model->technical_specification = $request->post('technical_specification');
        $model->uses = $request->post('uses');
        $model->warranty = $request->post('warranty');
        $model->status = 1;
        //dd($model);
        $model->save();
        $pid = $model->id;


        /*Product Arttribute Insert Start*/

        foreach ($skuAttr as $key => $value) {
            //dd($mrpAttr);
            $ProductAttrArr['product_id'] = $pid;
            $ProductAttrArr['size_id'] = $size_idAttr[$key];
            $ProductAttrArr['color_id'] = $color_idAttr[$key];
            $ProductAttrArr['sku'] = $skuAttr[$key];
            // $ProductAttrArr['attr_image'] = 'p';
            $ProductAttrArr['mrp'] = $mrpAttr[$key];
            $ProductAttrArr['price'] = $priceAttr[$key];
            $ProductAttrArr['qty'] = $qtyAttr[$key];
            //$ProductAttrArr['id'] = $pAttr[$key];
            //dd($ProductAttrArr['id']);

            if ($request->hasFile("attr_image.$key")) {
                $rand = rand('0000', '9999');
                $image = $request->file("attr_image.$key");
                //dd("attr_image.$key");
                $ext = $image->extension();
                $image_name = time() . $rand . '_attr' . '.' . $ext;
                $request->file("attr_image.$key")->move('upload', $image_name);
                $ProductAttrArr['attr_image'] = $image_name;
            }

            if ($pAttr[$key] != '') {
                DB::table('products_attr')->where(['id' => $pAttr[$key]])->update($ProductAttrArr);
            } else {
                DB::table('products_attr')->insert($ProductAttrArr);
            }
        }
        /*Product Arttribute Insert End*/

        /*Product Images Insert Start*/
        $pImages = $request->post('pimages_id');
        foreach ($pImages as $key => $value) {

            $ProductImages['product_id'] = $pid;

            if ($request->hasFile("images.$key")) {
                $rand = rand('0000', '9999');
                $image = $request->file("images.$key");
                //dd("attr_image.$key");
                $ext = $image->extension();
                $image_name = time() . $rand . '_image' . '.' . $ext;
                $request->file("images.$key")->move('upload', $image_name);
                $ProductImages['image'] = $image_name;
            }
            if ($pImages[$key] != '') {
                DB::table('product_images')->where(['id' => $pImages[$key]])->update($ProductImages);
            } else {
                DB::table('product_images')->insert($ProductImages);
            }
        }

        /*Product Images Insert End*/


        $request->session()->flash('message', $msg);
        return redirect('admin/product');
    }


    public function delete(Request $request, $id)
    {
        //echo $id;
        $model = Product::find($id);
        $model->delete();
        DB::table('products_attr')->where(['product_id' => $id])->delete();
        DB::table('product_images')->where(['product_id' => $id])->delete();
        $request->session()->flash('message', 'product deleted successfully');
        return redirect('admin/product');
    }

    public function product_attr_delete(Request $request, $pattr_id, $id)
    {
        //dd($pattr_id);
        DB::table('products_attr')->where(['id' => $pattr_id])->delete();
        return redirect('admin/product/manage_product/' . $id);
    }

    public function product_image_delete(Request $request, $pimage_id, $id)
    {
        //dd($pattr_id);
        DB::table('product_images')->where(['id' => $pimage_id])->delete();
        return redirect('admin/product/manage_product/' . $id);
    }

    public function status(Request $request, $type, $id)
    {
        // echo $type;
        // echo $id;
        $model = Product::find($id);
        $model->status = $type;
        $model->save();
        $request->session()->flash('message', 'product status updated');
        return redirect('admin/product');
    }
}
