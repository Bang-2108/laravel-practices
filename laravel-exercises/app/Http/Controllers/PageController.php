<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Slide;
use App\Models\Comment;
use App\Models\TypeProduct;
use App\Models\BillDetail;

class PageController extends Controller
{

    public function getIndex()
    {
        $slide = Slide::all();
        $new_product = Product::where("new", "1")->paginate(4);
        $promotion_product = Product::where("promotion_price", "1")->paginate(8);
        $type_product = TypeProduct::all(); 

        return view("pages.homepage", compact("slide", "new_product", "promotion_product", "type_product"));
    }

    public function getLoaiSP($type)
    {
        $sp_theoloai = Product::where("id_type",$type)->get();
        $type_product = TypeProduct::all();
        $sp_khac = Product::where("id_type",'<>',$type)->paginate(3);
        return view('pages.categories', compact('sp_theoloai','type_product','sp_khac'));
    }

    public function getDetail (Request $request) {
        $products = Product::where('id', $request -> id) -> first();
        $type_product = TypeProduct::all();
        // $splienquan = Product::where('id', '<>', $products->id) -> where('id_type', '=', $products->id_type) -> paginate(3);
        $splienquan = Product::where('id', '<>', $products -> id, 'and', 'id_type', '=', $products -> id_type,) -> paginate(3);
        $comments = Comment::where('id_product', $request -> id) -> get();
        // return view('pages.detail', compact('products', 'splienquan', 'comments'));
        return view('pages.detail', compact('products', 'splienquan', 'comments', 'type_product'));

    }
    public function getContact() {
        $type_product = TypeProduct::all();
        return view('pages.contact',  compact('type_product'));
    }
    public function getAbout() {
        $type_product = TypeProduct::all();
        return view('pages.about',  compact('type_product'));
    }

    /// Admin
    public function getIndexAdmin() {
        $products = Product::all();
        $type_product = TypeProduct::all();
        $sumSold = BillDetail::count();
        return view('pageadmin.admin')->with(['products' => $products, 'type_product' => $type_product, 'sumSold' => $sumSold]);
    }         
    public function getAdminAdd() {
        return view('pageadmin.formAdd');
    }
    public function getAdminEdit($id) {
        $products = Product::find($id);
        return view('pageadmin.formEdit') -> with(['products' => $products]);
    }
    public function exportAdminProduct() {

    }
}
