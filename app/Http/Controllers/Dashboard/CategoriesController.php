<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Rules\FilterRule;

class CategoriesController extends Controller
{
    //
    public function index()
    {
        $request = request();
        $query= Category::query();
        $name= $request->query('name');
        $status = $request->query('status');
        if($name){
            $query->where('name','like',"%$name%");
        }
        if($status){
            $query->where('status',$status);
        }
        // $categories = Category::all();
        // return view('dashboard.pages.categories.index', compact('categories'));
     
        return view('dashboard.pages.categories.index',[
            'categories'=> $query->withCount('products')->paginate(4)
        ]);
    }

    public function create()
    {
        $category = new Category();
        return view('dashboard.pages.categories.create', compact('category'));
    }
    public function store(Request $request)
    {
        $request->validate([
            // 'name' => 'required',
            // 'description' => 'required',

            // 'name'=> 'required|max:20|min:5'
            // 'name' => 'required|between:2,20'

            'name' => [
                'required',
                'between:5,20',
                'unique:categories,name',
                'filter'
                // function($attribute, $value, $fail)
                // {
                //     if($value === 'bar'){
                //         $fail('bar is not allowed');
                //     }
                // }
            ],

            // 'description' => [
            //     'required',
            //     'min:10',
            //     'max:255'
            // ]
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->slug = $category->name;
        $category->description = $request->description;
        $category->status = $request->status;
        $category->save();
        return redirect()->route('dashboard.categories.index')->with('success', 'Category Created Successfully');
    }
    public function edit($id)
    {
        $category = Category::find($id);
        return view('dashboard.pages.categories.edit', compact('category'));
    }
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status;
        $category->save();
        return redirect(route('dashboard.categories.index'))->with('success', 'Category Updated Successfully');
    }
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect(route('dashboard.categories.index'))->with('success', 'Category Deleted Successfully');
    }
}
