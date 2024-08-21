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
        //print_array($result['products'][0]->category_id);

        $result['related_products'] =
            DB::table('products')
            ->where(['status' => 1])
            ->where(['category_id' => $result['products'][0]->category_id])
            ->get();
        print_array($result);

        return view('front.product', $result);
    }
}