<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function addNewProduct(Request $request){
        if($request->has('submit')){
            $this->validate($request, [
                'productName' => 'required|max:255',
                'productCount' => 'required',
                'productPrice' => 'required'
            ]);

            $product = new Product;

            $user_id = Auth::user()->id;
            $image = $request->file('productPhoto');
            $photoName = $image->getClientOriginalName();
            $photoData = $image->move(public_path('images/' . $user_id), $photoName);
            $name = $request->productName;
            $description = $request->productDescription;
            $count = $request->productCount;
            $price = $request->productPrice;

            $product->photo_name = $photoName;
            $product->name = $name;
            $product->description = $description;
            $product->count = $count;
            $product->price = $price;
            $product->user_id = $user_id;
            $product->save();
            return redirect('/');
        } elseif($request->has('cancel')){
            return redirect('/');
        }
        return view('product.add');
    }

    public function editProduct(Request $request, $id){
        $user_id = Auth::user()->id;
        $product = Product::where('id', $id)->where('user_id', $user_id)->first();
        if($product == null){
            abort(403);
        }
        if($request->has('submit')){
            $image = $request->file('productPhoto');
            if($image){
                $photoName = $image->getClientOriginalName();
                $photoData = $image->move(public_path('images/' . $user_id), $photoName);
                $product->photo_name = $photoName;
            }
            $product->name = $request->productName;
            $product->description = $request->productDescription;
            $product->price = $request->productPrice;
            $product->count = $request->productCount;
            $product->save();
            return redirect('/');
        } elseif ($request->has('cancel')){
            return redirect('/');
        }
        return view('product.edit', ['product' => $product]);
    }

    public function deleteProduct(Request $request, $id){
        $user_id = Auth::user()->id;
        $product = Product::where('id', $id)->where('user_id', $user_id)->delete();
        return redirect('/');
    }

    public function viewProduct(Request $request, $id){
        $user_id = Auth::user()->id;
        $product = Product::where('id', $id)->where('user_id', $user_id)->first();
        if($product == null){
            abort(403);
        }
        return view('product.view', ['product' => $product]);
    }
}
