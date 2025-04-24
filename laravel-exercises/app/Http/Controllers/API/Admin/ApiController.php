<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Lấy danh sách tất cả sản phẩm
     */
    public function index()
    {
        $products = Product::with('typeProduct')->get();
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }
}
