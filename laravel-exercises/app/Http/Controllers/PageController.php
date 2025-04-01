<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


use App\Models\Product;
use App\Models\Slide;
use App\Models\Comment;
use App\Models\TypeProduct;
use App\Models\BillDetail;
use App\Models\Cart;
class PageController extends Controller
{

    public function getIndex()
    {
        $slide = Slide::all();
        $new_product = Product::where("new", "1")->paginate(4);
        $promotion_product = Product::where("promotion_price", "<>", "0")->paginate(8);
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

    // public function getLoaiSP($type)
    // {
    //     $products = Product::where("id_type", $type)->get();
    //     $type_product = TypeProduct::all();
    //     $sp_khac = Product::where("id_type", '<>', $type)->paginate(3);
        
    //     return view('pages.categories', compact('products', 'type_product', 'sp_khac'));
    // }
    
    
    public function getDetail (Request $request) {
        $products = Product::where('id', $request -> id) -> first();
        $type_product = TypeProduct::all();
        $splienquan = Product::where('id', '<>', $products -> id, 'and', 'id_type', '=', $products -> id_type,) -> paginate(3);
        $comments = Comment::where('id_product', $request -> id) -> get();
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
    public function getSearch(Request $request) {
        $key = $request->input('search'); 
        $products = Product::where('name', 'LIKE', "%$key%")->paginate(3);
        return view('pages.search', compact('products', 'key'));
    }
// Cart
    public function getAddToCart(Request $req, $id)
    {
        $product = Product::find($id);
        if (!$product) return redirect()->back();

        $oldCart = Session('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $id);
        $req->session()->put('cart', $cart);

        return redirect()->back();
    }

    public function getDelItemCart($id){
        $oldCart = Session::has('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if(count($cart->items)>0){
        Session::put('cart',$cart);

        }
        else{
            Session::forget('cart');
        }
        return redirect()->back();
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
