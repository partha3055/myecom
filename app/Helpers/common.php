<?php

use Illuminate\Support\Facades\DB;

function print_array($arr)
{
    echo "<pre>";
    print_r($arr);
    echo die();
}
function getTopNavCat()
{
    $result = DB::table('categories')
        ->where(['status' => 1])
        ->get();
    //print_array($result);
    //$arr = [];
    foreach ($result as $row) {
        $arr[$row->id]['category_name'] = $row->category_name;
        $arr[$row->id]['parent_category_id'] = $row->parent_category_id;
    }
    $str = buildTreeView($arr, 0);
    return $str;
}

$html = '';
function buildTreeView($arr, $parent, $level = 0, $prelevel = -1)
{
    global $html;
    foreach ($arr as $id => $data) {
        if ($parent == $data['parent_category_id']) {
            if ($level > $prelevel) {
                if ($html == '') {
                    $html .= '<ul class="nav navbar-nav">';
                } else {
                    $html .= '<ul class="dropdown-menu">';
                }
            }
            if ($level == $prelevel) {
                $html .= '</li>';
            }
            $html .= '<li><a href="#">' . $data['category_name'] . '<span class="caret"></span></a>';
            if ($level > $prelevel) {
                $prelevel = $level;
            }
            $level++;
            buildTreeView($arr, $id, $level, $prelevel);
            $level--;
        }
    }
    if ($level == $prelevel) {
        $html .= '</li></ul>';
    }
    return $html;
}
/*
composer dump-autoload

"files":[
     "app/helpers/common.php"
]
*/

function getUserTempId()
{
    if (session()->has('USER_TEMP_ID') === null) {
        // $USER_TEMP_ID = Session::get('USER_TEMP_ID');
        // dd($USER_TEMP_ID);
        $rand = rand(111111111, 999999999);
        session()->put('USER_TEMP_ID', $rand);
        return $rand;
    } else {
        return session()->get('USER_TEMP_ID');
    }
}