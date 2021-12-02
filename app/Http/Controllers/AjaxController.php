<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function changeCount(Request $request){
        $user_id = Auth::user()->id;
        $count = $request->count;
        $product_id = $request->product_id;
        $product = Product::where('id', $product_id)->where('user_id', $user_id)->first();
        $product->count = $count;
        $product->save();
        return $count . " " . $user_id . " " . $product_id;
    }
}
