<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Slide;
use App\Models\TypeProduct;

class PageController extends Controller
{


    public function getIndex()
    {
        $slide = Slide::all();
        $new_product = Product::where("new", "1")->paginate(4);
        $promotion_product = Product::where("promotion_price", "1")->paginate(8);
        return view("pages.homepage", compact("slide", "new_product", "promotion_product"));
    }

    public function getLoaiSP($type)
    {
        $sp_theoloai = Product::where("id_type",$type)->get();
        $type_product = TypeProduct::all();
        $sp_khac = Product::where("id_type",'<>',$type)->paginate(3);
        return view('pages.categories', compact('sp_theoloai','type_product','sp_khac'));

    }
}
