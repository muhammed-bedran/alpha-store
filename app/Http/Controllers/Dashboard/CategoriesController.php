<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Rules\FilterRule;
use Illuminate\Support\Facades\Gate;

class CategoriesController extends Controller
{
    //
    public function index()
    {
        Gate::authorize('categories.view');
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
        Gate::authorize('categories.create');

        $category = new Category();
        return view('dashboard.pages.categories.create',[
            'category' => $category,
           
        ]);
    }
    public function store(Request $request)
    {
        Gate::authorize('categories.create');

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
        Gate::authorize('categories.edit');

        $category = Category::find($id);
        return view('dashboard.pages.categories.edit', [
            'category' => $category,
           
        ]);
    }
    public function update(Request $request, $id)
    {
        Gate::authorize('categories.edit');

        $category = Category::find($id);
        $oldName = $category->name;
        $oldDescription = $category->description;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status;
        $category->save();
        if($oldName !== $category->name){
            $category->renameTranslationKey($oldName, $category->name);
        }
        if($oldDescription !== $category->description){
            $category->renameTranslationKey($oldDescription, $category->description);
        }
        return redirect(route('dashboard.categories.index'))->with('success', 'Category Updated Successfully');
    }
    public function destroy($id)
    {
        Gate::authorize('categories.delete');

        $category = Category::find($id);
        $category->deleteTranslationsFromJson();
        $category->delete();
        return redirect(route('dashboard.categories.index'))->with('success', 'Category Deleted Successfully');
    }
}
