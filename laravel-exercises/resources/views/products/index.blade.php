<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">							
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Danh sách sản phẩm</h2>
        @if(session('error'))
        <div class="alert alert danger">{{session('error')}}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Mô tả sản phẩm</th>
                    <th>Giá sản phẩm</th>
                    <th>Số lượng sản phẩm</th>
                </tr>
            </thead>

            <tbody>
                @foreach($products as $product) 
                <tr>
                    <td>{{$product['id'] }}</td>
                    <td>{{$product['name'] }}</td>
                    <td>{{$product['description'] ?? "không có mô tả"}}</td>
                    <td>{{number_format ($product['price'] ?? 0, 2)}} $</td>
                    <td>{{$product['quantity'] ?? 0}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>