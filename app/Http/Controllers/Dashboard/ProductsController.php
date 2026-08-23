<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Store;

class ProductsController extends Controller
{
    //
    public function index()
    {
        $request = request();
        $query = Product::query()->with(['category', 'store']);

        $name = $request->query('name');
        $status = $request->query('status');

        if ($name) {
            $query->where('name', 'like', "%{$name}%");
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }

        if ($request->filled('store_id')) {
            $query->where('store_id', $request->integer('store_id'));
        }

        return view('dashboard.pages.products.index', [
            'products' => $query->latest()->paginate(10)->withQueryString(),
            'categories' => Category::pluck('name', 'id'),
            'stores' => Store::pluck('name', 'id'),
        ]);
    }
    public function create()
    {
 
        return view('dashboard.pages.products.create',[
            'product' => new Product(),
            'categories' => Category::pluck('name','id'),
            'stores' => Store::pluck('name','id')
        ]);
    }
    public function store(Request $request){
      $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|gte:0',
        'status' => 'required|in:active,inactive',
        'category_id' => 'required|exists:categories,id',
        'store_id' => 'required|exists:stores,id',
      ], [
        'price.gte' => 'Price must be 0 or greater.',
      ]);
      Product::create($request->all());
      return redirect()->route('dashboard.products.index')->with('success','Product Created Successfully');
    }
      public function edit(Product $product)
      {
  
          return view('dashboard.pages.products.edit',[
              'product' => $product,
              'categories' => Category::pluck('name','id'),
              'stores' => Store::pluck('name','id')
          ]);
      }
      public function update(Request $request, Product $product){
        $request->validate([
          'name' => 'required|string|max:255',
          'description' => 'nullable|string',
          'price' => 'required|numeric|gte:0',
          'status' => 'required|in:active,inactive',
          'category_id' => 'required|exists:categories,id',
          'store_id' => 'required|exists:stores,id',
        ], [
          'price.gte' => 'Price must be 0 or greater.',
        ]);
        $product->update($request->all());
        return redirect()->route('dashboard.products.index')->with('success','Product Updated Successfully');
      }
      public function destroy(Product $product){
        $product->delete();
        return redirect()->route('dashboard.products.index')->with('success','Product Deleted Successfully');
      }
}
