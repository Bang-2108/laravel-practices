<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


use App\Models\Product;
use App\Models\Slide;
use App\Models\Comment;
use App\Models\TypeProduct;
use App\Models\BillDetail;
use App\Models\Users;

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

    // Signup - Signin
    public function getRegister() {
        return view('pages.register');
    }
    public function postRegister(Request $request) {
        $input = $request -> validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);

        $input['password'] =bcrypt($input['password']);
        Users::create($input);

        echo '
            <script>
                alert("Đăng ký thành công. Vui lòng đăng nhập.");
                window.location.assign("login");
            </script>';
    }
    
    public function getLogin() {
        return view('pages.login');
    }
    public function postLogin(Request $request) {
        $login = [
            'email' => $request -> input('email'),
            'password' => $request -> input('pw')
        ];
        if(Auth::attempt($login)) {
            $user = Auth::user();
            Session::put('user', $user);

            echo    '<script>
                        alert("Đăng nhập thành công.");
                        window.location.assign("homepage");
                    </script>';
                    '<script>
                        alert("Đăng nhập thất bại");
                        window.location.assgin("login");
                    </script>';
                
            }
        }

        public function Logout() {
            Session::forget('user');
            // Session::forrget('');
            return redirect('/homepage');
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
