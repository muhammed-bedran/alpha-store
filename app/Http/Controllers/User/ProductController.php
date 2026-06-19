<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    //
    public function index(Request $request)
    {
        $store = Auth::user()->store;
        $query = Product::query()->where('store_id', $store->id)->with('category');
        if ($name = $request->query('name')) 
        {
            $query->where('name', 'like', "%$name%");
        }
        if($status = $request->query('status'))
        {
            $query->where('status', $status);
        }
        $products = $query->latest()->paginate(10);
        return view('user.pages.products.index', compact('products'));
    }
    public function create()
    {
        $product = new Product();
        $categories = Category::where('status', 'active')->get();
        return view('user.pages.products.create',compact('product','categories'));
    }
    public function store(Request $request)
    {
        $store= Auth::user()->store;
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
          
        ]);
        $product = new Product();
        $product->fill([
            'name' => $data['name'],
            'description' => $data['description'],
            'status' => $data['status'],
            'category_id' => $data['category_id'],
            'price' => $data['price'],
          
            'store_id' => $store->id,
        ]);
        $product->save();
        return redirect()
        ->route('user.products.index')
        ->with('success', 'Product created successfully');
    }
    public function edit (Product $product){
        $this->authorizeProduct($product);
        $categories = Category::where('status', 'active')->get();
        return view('user.pages.products.edit',compact('product','categories'));
    }
    public function update(Request $request, Product $product){
        $this->authorizeProduct($product);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
        ]);
        $product->fill([
            'name' => $data['name'],
            'description' => $data['description'],
            'status' => $data['status'],
            'category_id' => $data['category_id'],
            'price' => $data['price'],
        ]);
        $product->save();
        return redirect()
        ->route('user.products.index')
        ->with('success', 'Product updated successfully');
    }
    public function destroy(Product $product){
        $this->authorizeProduct($product);
        $product->delete();
        return redirect()
        ->route('user.products.index')
        ->with('success', 'Product deleted successfully');
    }
    private function authorizeProduct(Product $product)
    {
        if($product->store_id !== Auth::user()->store->id){
            abort(403);
        }
    }
}
