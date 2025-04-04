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

    /**
     * Thêm mới một sản phẩm
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:100',
            'id_type' => 'nullable|integer',
            'description' => 'nullable|string',
            'unit_price' => 'nullable|numeric|min:0',
            'promotion_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'new' => 'boolean',
        ]);

        $product = Product::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được thêm thành công!',
            'data' => $product
        ], 201);
    }

    /**
     * Xem chi tiết một sản phẩm
     */
    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'data' => $product->load('typeProduct')
        ]);
    }

    /**
     * Cập nhật sản phẩm
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:100',
            'id_type' => 'nullable|integer',
            'description' => 'nullable|string',
            'unit_price' => 'nullable|numeric|min:0',
            'promotion_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'new' => 'boolean',
        ]);

        $product->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được cập nhật thành công!',
            'data' => $product
        ]);
    }

    /**
     * Xóa sản phẩm
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được xóa thành công!'
        ]);
    }
}
