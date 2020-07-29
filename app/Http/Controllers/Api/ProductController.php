<?php

namespace App\Http\Controllers\Api;

use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @var Product
     */
    private $product;

    public function __construct(Product $product){
       $this->product = $product;
    }
   
    public function index(){
        $products = $this->product->all();
   
        return response()->json($products);
    }

    public function show($id){
        $products = $this->product->find($id);
   
        return response()->json($products);
    }

    public function save(Request $request){
        $data = $request->all();
        $product = $this->product->create($data);

        return response()->json($product);
    }
}