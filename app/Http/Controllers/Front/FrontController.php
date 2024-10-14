<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        // getData();
        // die();

        $result['home_categories'] = DB::table('categories')
            ->where(['status' => 1])
            ->where(['is_home' => 1])
            ->get();
        foreach ($result['home_categories'] as $list) {
            $result['home_category_products'][$list->id] =
                DB::table('products')
                ->where(['status' => 1])
                ->where(['category_id' => $list->id])
                ->get();
            foreach ($result['home_category_products'][$list->id] as $list1) {
                $result['home_product_attr'][$list1->id] =
                    DB::table('products_attr')
                    ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
                    ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
                    ->where(['products_attr.product_id' => $list1->id])
                    ->get();
            }
            // echo "<pre>";
            // print_r($result);
            // die();
        }

        $result['home_brands'] = DB::table('brands')
            ->where(['status' => 1])
            ->where(['is_home' => 1])
            ->get();

        $result['home_featured_products'][$list->id] =
            DB::table('products')
            ->where(['status' => 1])
            ->where(['is_featured' => 1])
            ->get();
        foreach ($result['home_featured_products'][$list->id] as $list1) {
            $result['home_featured_product_attr'][$list1->id] =
                DB::table('products_attr')
                ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
                ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
                ->where(['products_attr.product_id' => $list1->id])
                ->get();
        }

        $result['home_tranding_products'][$list->id] =
            DB::table('products')
            ->where(['status' => 1])
            ->where(['is_tranding' => 1])
            ->get();
        foreach ($result['home_tranding_products'][$list->id] as $list1) {
            $result['home_tranding_product_attr'][$list1->id] =
                DB::table('products_attr')
                ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
                ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
                ->where(['products_attr.product_id' => $list1->id])
                ->get();
        }

        $result['home_discounted_products'][$list->id] =
            DB::table('products')
            ->where(['status' => 1])
            ->where(['is_discounted' => 1])
            ->get();
        foreach ($result['home_discounted_products'][$list->id] as $list1) {
            $result['home_discounted_product_attr'][$list1->id] =
                DB::table('products_attr')
                ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
                ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
                ->where(['products_attr.product_id' => $list1->id])
                ->get();
        }

        $result['home_banners'] = DB::table('home_banners')
            ->where(['status' => 1])
            ->get();
        //dd($result);
        // echo "<pre>";
        // print_r($result);
        // die();
        return view('front.index', $result);
    }
    public function product(Request $request, $slug)
    {
        $result['products'] =
            DB::table('products')
            ->where(['status' => 1])
            ->where(['slug' => $slug])
            ->get();
        foreach ($result['products'] as $list1) {
            $result['product_attr'][$list1->id] =
                DB::table('products_attr')
                ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
                ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
                ->where(['products_attr.product_id' => $list1->id])
                ->get();
        }
        foreach ($result['products'] as $list1) {
            $result['product_images'][$list1->id] =
                DB::table('product_images')
                ->where(['product_id' => $list1->id])
                ->get();
        }
        //print_array($result);

        //print_array($result['products'][0]->category_id);
        $result['related_products'] =
            DB::table('products')
            ->where(['status' => 1])
            ->where('slug', '!=', $slug)
            ->where(['category_id' => $result['products'][0]->category_id])
            ->get();
        foreach ($result['related_products'] as $list1) {
            $result['related_product_attr'][$list1->id] =
                DB::table('products_attr')
                ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
                ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
                ->where(['products_attr.product_id' => $list1->id])
                ->get();
        }

        //print_array($result);

        return view('front.product', $result);
    }
    public function addToCart(Request $request)
    {
        // print_array($_POST);
        if ($request->session()->has('FRONT_USER_LOGIN')) {
            $uid = $request->session()->get('FRONT_USER_LOGIN');
            $user_type = "Reg";
        } else {
            $uid = getUserTempId();
            $user_type = "Not-Reg";
        }
        $size_id = $request->post('size_id');
        $color_id = $request->post('color_id');
        $pqty = $request->post('pqty');
        $product_id = $request->post('product_id');

        $result = DB::table('products_attr')
            ->select('products_attr.id')
            ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
            ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
            ->where(['products_attr.product_id' => $product_id])
            ->where(['sizes.size' => $size_id])
            ->where(['colors.color' => $color_id])
            ->get();
        $product_attr_id = $result[0]->id;

        $check = DB::table('cart')
            ->where(['user_id' => $uid])
            ->where(['user_type' => $user_type])
            ->where(['product_id' => $product_id])
            ->where(['product_attr_id' => $product_attr_id])
            ->get();

        if (isset($check[0])) {
            $updated_id = $check[0]->id;
            if ($pqty == 0) {
                DB::table('cart')
                    ->where(['id' => $updated_id])
                    ->delete();
                $msg = 'removed';
            } else {
                DB::table('cart')
                    ->where(['id' => $updated_id])
                    ->update(['qty' => $pqty]);
                $msg = 'updated';
            }
        } else {
            $id = DB::table('cart')->insertGetId([
                'user_id' => $uid,
                'user_type' => $user_type,
                'product_id' => $product_id,
                'product_attr_id' => $product_attr_id,
                'qty' => $pqty,
                'added_on' => date('Y-m-d')
            ]);
            $msg = 'added';
        }
        // return response()->json(['id' => $id, 'msg' => $msg]);
        return response()->json(['msg' => $msg]);
    }

    public function cart(Request $request)
    {
        if ($request->session()->has('FRONT_USER_LOGIN')) {
            $uid = $request->session()->get('FRONT_USER_LOGIN');
            $user_type = "Reg";
        } else {
            $uid = getUserTempId();
            $user_type = "Not-Reg";
        }
        $result['cart'] = DB::table('cart')
            ->leftJoin('products', 'products.id', '=', 'cart.product_id')
            ->leftJoin('products_attr', 'products_attr.id', '=', 'cart.product_attr_id')
            ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
            ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
            ->where(['user_id' => $uid])
            ->where(['user_type' => $user_type])
            ->select('cart.qty', 'products.id as pid', 'products.name', 'products.image', 'products.slug', 'products_attr.id as attr_id', 'products_attr.price', 'sizes.size', 'colors.color')
            ->get();

        // print_array($result);

        return view('front.cart', $result);
    }
}
