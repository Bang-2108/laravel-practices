<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //Cake_Shop Add product
    public function postAdminAdd(Request $request)							
    {							
        $product = new Product();							
        if ($request->hasFile('inputImage')) {							
            $file = $request->file('inputImage');							
            $fileName = $file->getClientOriginalName('inputImage');							
            $file->move('source/image/product', $fileName);							
        }							
        $file_name = null;							
        if ($request->file('inputImage') != null) {							
            $file_name = $request->file('inputImage')->getClientOriginalName();							
        }
        
        $product -> name = $request -> inputName;
        $product -> image = $file_name;
        $product -> description = $request -> inputDescription;
        $product -> unit_price = $request -> inputPrice;
        $product -> promotion_price = $request -> inputPromotionPrice;
        $product -> unit = $request -> inputUnit;
        $product -> new = $request -> inputNew;
        $product -> id_type = $request -> inputType;
        $product -> save();
        return $this -> getIndexAdmin();

    }
       
    // Cake_Shop Edit product
    public function postAdminEdit(Request $request)							
    {							
        $id = $request -> edit;

        $product = Product::find($id);							
        if ($request->hasFile('editImage')) {							
            $file = $request->file('editImage');							
            $fileName = $file->getClientOriginalName('editImage');							
            $file->move('source/image/product', $fileName);							
        }							
        $file_name = null;							
        if ($request->file('editImage') != null) {							
            $file_name = $request->file('editImage')->getClientOriginalName();							
        }
        
        $product -> name = $request -> editName;
        $product -> image = $file_name;
        $product -> description = $request -> editDescription;
        $product -> unit_price = $request -> editPrice;
        $product -> promotion_price = $request -> editPromotionPrice;
        $product -> unit = $request -> editUnit;
        $product -> new = $request -> editNew;
        $product -> id_type = $request -> editType;
        $product -> save();
        return $this -> getIndexAdmin();

    }

    // Cake_Shop Delete product
    public function postAdminDelete($id) {
        $product = Product::find($id);
        $product -> delete();
        return $this -> getIndexAdmin();
    }
    
    // Call funtion getIndexAdmin()
    public function getIndexAdmin()
    {
        return view('pageadmin.admin'); 
    }
       
}