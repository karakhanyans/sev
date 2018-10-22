<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function index()
    {
        $products = array();
        if (Storage::disk('public')->exists('products.json')) {
            $products = json_decode(Storage::disk('public')->get('products.json'));
        }
        return view('products.index',['products' => $products]);
    }

    public function store(Request $request){
        $rules = [
            'name' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ];
        $this->validate($request, $rules);
        $data = $request->all();
        $insertRow = array(
            'name' => $data['name'],
            'quantity' => $data['quantity'],
            'price' => $data['price'],
            'created_at' => date('Y-m-d H:i:s')
        );
        $products = array();
        if (Storage::disk('public')->exists('products.json')) {
            $products = json_decode(Storage::disk('public')->get('products.json'),true);
            array_push($products,$insertRow);
        }
        if(empty($products)){
            $products = array($insertRow);
        }
        Storage::disk('public')->put('products.json', json_encode($products));
        return response()->json($products);
    }
}
