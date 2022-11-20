<?php
use Illuminate\Support\Facades\DB;

function getTopNavCategories()
{
    $html = '';
    $result['nav_categories'] = DB::table('categories')->where('category_parent_id', '=', null)->get();
    $html .= '<ul class="nav navbar-nav">';
    foreach ($result['nav_categories'] as $root_category){
        $html .= '<li>' . '<a href="/category_page/' . $root_category->category_slug . "/1/9" . '">' . 
                    $root_category->category_name . '</a>' . buildTreeView($root_category->id) . '</li>';
    }
    $html .= '</ul>';
    return $html;
}

function buildTreeView($category_parent_id){
    $tree_view = '';
    $sub_categories = DB::table('categories')->where('category_parent_id', '=', $category_parent_id)->get();
    if ($sub_categories->isNotEmpty()){
        $tree_view .= '<ul class="dropdown-menu">';
        foreach ($sub_categories as $sub_category){
            $tree_view.= '<li>' . '<a href="/category_page/' . $sub_category->category_slug . "/1/9" . '">' . 
                    $sub_category->category_name . '</a>' . buildTreeView($sub_category->id) . '</li>';
        }
        $tree_view .= '</ul>';
    }
    return $tree_view;
}

?>