<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendEmail;
use App\Mail\MailNotify;


use App\Models\Users;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // Signup - Signin
    public function getRegister() {
        return view('pages.register');
    }
    public function postRegister(Request $request)
    {
        $input = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);
    
        $input['password'] = bcrypt($input['password']);
        Users::create($input);
    
        // Dữ liệu gửi mail
        $data = [
            'type' => 'Email chào mừng đăng ký tài khoản',
            'thanks' => 'Cảm ơn ' . $input['name'] . ' đã đăng ký tài khoản tại tiệm bánh Laravel.',
            'cart' => null, // Không có giỏ hàng nên để null
            'content' => 'Chúc bạn có trải nghiệm ngọt ngào tại tiệm bánh Laravel!',
        ];

        // $emailData = [
        //     'name' => $input['name'],
        // ];
        // Mail::to($input['email'])->send(new MailNotify($emailData));
        // Gửi mail qua job (hàng đợi)
        SendEmail::dispatch($data, $input['email'])->delay(now()->addSeconds(10));
    
        echo '
            <script>
                alert("Đăng ký thành công. Vui lòng kiểm tra email.");
                window.location.assign("login");
            </script>';
    }
    
    
    public function getLogin() {
        return view('pages.login');
    }
    public function postLogin(Request $request) {
        $login = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
    
        if (Auth::attempt($login)) {
            $user = Auth::user();
            Session::put('user', $user);
    
            echo    '<script>
            
                        alert("Đăng nhập thành công.");
                        window.location.assign("homepage");
                    </script>';
        } else {
            echo    '<script>
                        alert("Đăng nhập thất bại.");
                        window.location.assign("login");
                    </script>';
        }
    }
    
        public function Logout() {
            Session::forget('user');
            // Session::forrget('');
            return redirect('/homepage');
        }

}
