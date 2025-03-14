<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sản phẩm</title>
</head>

<body>
    @extends('layouts.app') @section('content')
    <div class="container mt-5">
        <h2>Chỉnh sửa sản phẩm</h2>
        <form action="{{ route('products.update', $product['id']) }}" method="POST">
            @csrf @method('PUT')
            <label for="">Tên sản phẩm:</label>
            <input type="text" name="name" value="{{ $product['name'] }}" required class="form-control mb-3">

            <label for="">Mô tả sản phẩm:</label>
            <textarea name="description" class="form-control mb-3">{{ $product['description'] ?? "Không có mô tả" }}</textarea>

            <label for="">Giá sản phẩm:</label>
            <input type="number" name="price" value="{{ $product['price'] ?? 0, 2}}" required class="form-control mb-3">

            <label for="">Số lượng sản phẩm:</label>
            <input type="number" name="quantity" value="{{ $product['quantity'] ?? 0}}" required class="form-control mb-3">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
    @endsection
</body>

</html>