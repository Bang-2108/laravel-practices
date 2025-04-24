<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class VnPayController extends Controller
{
    public function payment(Request $req)
    {
        if ($req->payment_method == "vnpay") {
            // Lấy thông tin giỏ hàng từ request
            $cart = json_decode($req->cart);
            $totalAmount = $req->bill_total;

            // Tạo mã giao dịch, thông tin thanh toán
            $cost_id = now()->timestamp;

            $vnp_TmnCode = "OVP9MD6Z"; 
            $vnp_HashSecret = "Z8RQ57OHJWHPCH8CT0Q5FGMS8XZ00XL3"; 
            $vnp_Url = "https://www.vnpayment.vn/paymentv2/vpcpay.html"; 
            $vnp_Returnurl = "http://localhost:8000/return-vnpay"; 

            $vnp_TxnRef = now()->format("YmdHis");
            $vnp_OrderInfo = "Thanh toán giỏ hàng";
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $totalAmount * 100; 
            $vnp_Locale = 'vn';
            $vnp_IpAddr = $req->ip();
            $vnp_BankCode = 'NCB'; 

            $inputData = [
                "vnp_Version" => "2.0.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
            ];

            if (!empty($vnp_BankCode)) {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }

            ksort($inputData);

            $hashdata = '';
            $query = '';
            $i = 0;
            foreach ($inputData as $key => $value) {
                $hashdata .= ($i ? '&' : '') . $key . "=" . $value;
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
                $i++;
            }

            $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
            $vnp_Url .= "?" . $query . 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;

            // Lưu thông tin thanh toán vào bảng payments
            $payment = new Payment();
            $payment->bill_id = $req->bill_id; 
            $payment->payment_method = "vnpay";
            $payment->amount = $totalAmount;
            $payment->status = 'PENDING'; 
            $payment->save();

            return redirect()->away($vnp_Url);
        } else {
            echo "<script>alert('Đặt hàng thành công')</script>";
            return redirect('/return-vnpay');
        }
    }


    public function returnVnPay(Request $request)
    {
        $vnp_SecureHash = $request->input('vnp_SecureHash');
        $vnp_HashSecret = "Z8RQ57OHJWHPCH8CT0Q5FGMS8XZ00XL3"; 

        // Lấy tất cả tham số từ request
        $inputData = $request->all();
        
        // Xóa trường vnp_SecureHash khỏi mảng dữ liệu
        unset($inputData['vnp_SecureHash']);
        
        ksort($inputData);

        $hashdata = '';
        foreach ($inputData as $key => $value) {
            $hashdata .= $key . "=" . $value . "&";
        }

        // Tạo mã bảo mật
        $vnp_SecureHashCheck = hash('sha256', $vnp_HashSecret . rtrim($hashdata, '&'));

        // Kiểm tra mã bảo mật
        if ($vnp_SecureHash === $vnp_SecureHashCheck) {
            $orderId = $request->input('vnp_TxnRef');
            $paymentStatus = $request->input('vnp_ResponseCode'); 

            // Lấy thông tin thanh toán từ bảng Payment
            $payment = Payment::where('bill_id', $orderId)->first();

            if ($payment) {
                if ($paymentStatus == '00') {
                    $payment->status = 'COMPLETED';
                } else {
                    $payment->status = 'FAILED';
                }
                $payment->save();
            }

            // Chuyển hướng người dùng tới trang kết quả thanh toán
            return redirect()->route('vnpay.return-vnpay', ['status' => $payment->status]);
        } else {
            return redirect()->route('vnpay.fail', ['status' => 'FAILED']);
        }
    }

    public function paymentResult($status)
    {
        return view('vnpay.return-vnpay', compact('status'));
    }
    public function paymentFail()
    {
        return view('vnpay.fail');
    }

}
