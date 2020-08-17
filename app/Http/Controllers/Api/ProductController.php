<?php

namespace App\Http\Controllers\Api;

use App\Product;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
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
   
    public function index(Request $request){
        $products = $this->product;

        //conditions=name:Breno;price=x
        if($request->has('conditions')){
            // Depois pesquisa o que esse método explode faz
            $expressions = explode(';', $request->get('conditions'));
            
            foreach($expressions as $e){
                $explode = explode('=', $e);
                $products = $products->where($explode[0], $explode[1]);
            }
        }

        if($request->has('fields')){
            $fields = $request->get('fields');

            /*
            * ----------------------------------------
            *   SelectRaw
            * ----------------------------------------
            *  Se eu tivesse usado o select normal
            *  para a query, ele não iria encontrar
            *  nada útil pois procuraria por um
            *  único campo chamado "name,price".
            *  Mas quando usamos o selectRaw, ele
            *  considera a vírgula como uma vírgula
            *  por fora, e não parte da string :)
            */
            $products = $products->selectRaw($fields);
        }
   
        return new ProductCollection($products->paginate(10));
    }

    public function show($id){
        $product = $this->product->find($id);
   
        //return response()->json($products);
        return new ProductResource($product);
    }

    public function save(Request $request){
        $data = $request->all();
        $product = $this->product->create($data);

        return response()->json($product);
    }

    public function update(Request $request){
        $data = $request->all();

        $product = $this->product->find($data['id']);
        $product->update($data);

        return response()->json($product);
    }

    public function delete($id){
        $product = $this->product->find($id);
        $product->delete();

        return response()->json(['data' => ['msg' => 'Produto foi removido com sucesso!']]);
    }
}
