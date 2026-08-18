<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    //
    public function index(Request $request){
        // http://127.0.0.1:8000/api/products
        //$perPage = min((int) $request->query('per_page',15),100);
        $products = Product::query()
        ->with(['category','store'])
       // ->when($request->query('status'),fn($query,$status) => $query->where('status',$status))
        ->latest()
        ->paginate();
        return response()->json($products);

    }
    public function show(Product $product){
        // http://127.0.0.1:8000/api/products/1
        $product->load(['category','store']);
        return response()->json($product);
    }
    protected function validateProductData(Request $request,?Product $product = null){
        $updating= $product !== null;
        $required = $updating ? 'sometimes' : 'required';
        return $request->validate([
            'name' => [$required ,
             'string', 
             'max:255', 
             Rule::unique('products', 'name')->ignore($product?->id),
             
             ],
            'description' => ['nullable','string', 'max:2000'],
            'price' => [$required,'numeric','min:0'],
            'store_id' => [$required,'exists:stores,id'],
            'category_id' => [$required,'exists:categories,id'],
            'status' => [$required,'in:active,inactive'],
        ]);
    }
    public function store(Request $request){
        // http://127.0.0.1:8000/api/products
        $data = $this->validateProductData($request);
        $product = new Product;
        $product->fill($data);
        $product->save();
        $product->load(['category','store']);
        return response()->json([
            'product' => $product,
            'message' => 'Product created successfully'

        ]);
    }
    public function destroy(Product $product){
        // http://127.0.0.1:8000/api/products/1
        $product->delete();
        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
    public function update(Request $request, Product $product){
        $data = $this->validateProductData($request,$product);
        $product->update($data);
        $product->load(['category','store']);
        return response()->json([
            'product' => $product,
            'message' => 'Product updated successfully'
        ]);
    }
}
// edit // create