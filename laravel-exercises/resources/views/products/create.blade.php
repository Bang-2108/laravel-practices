<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm </title>
</head>

<body>
    @extends('layouts.app') @section('content')
    <div class="container mt-5">
        <h2>Thêm sản phẩm</h2>
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <label for="">Tên sản phẩm:</label>
            <input type="text" name="name" placeholder="Tên sản phẩm" required class="form-control mb-3">

            <label for="">Mô tả sản phẩm:</label>
            <textarea name="description" placeholder="Mô tả" class="form-control mb-3"></textarea>

            <label for="">Giá sản phẩm:</label>
            <input type="number" name="price" placeholder="Giá" required class="form-control mb-3">

            <label for="">Số lượng sản phẩm:</label>
            <input type="number" name="quantity" placeholder="Số lượng" required class="form-control mb-3">
            <button type="submit" class="btn btn-success">Lưu</button>
        </form>
    </div>
    @endsection

</body>

</html>