<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\categoryRequest;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->paginate(5);
        return view('dashboard.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',
            'image' => 'required|image',
            'status' => ['in:active,archived'],
        ], [
            'required' => 'هذا الحقل مطلوب'
        ])->validate();

        $ex = $request->file('image')->getClientOriginalExtension();
        $new_img_name = 'categories_i'.time() . '.' . $ex;
        $request->file('image')->move(public_path('uploads'), $new_img_name);
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $new_img_name,
            'status' => $request->status,
        ]);
        return redirect()->route('dashboard.categories.index')
        ->with('success', 'تم انشاء مبادرة بنجاح !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        // return view('dashboard.categories.show',[
        //     'category' => $category
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(categoryRequest $request, Category $category)
    {
        // Validator::make($request->all(), [
        //     'name' => 'required|unique:categories,name,'. $category->id,
        //     'content' => 'required',
        //     'image' => 'nullable|image',
        //     'category_id' => 'required'
        // ], [
        //     'required' => 'هذا الحقل مطلوب'
        // ])->validate();
        
           $categories = Category::select('name')->first();
           if($categories!== null){
            return redirect()->back()->with(['error'=>'اسم الفئة موجود من قبل']);
           }
        $new_img_name = $category->image;
        if($request->has('image')) {
            // Upload image
            $ex = $request->file('image')->getClientOriginalExtension();
            $new_img_name = 'categories_i'.time() . '.' . $ex;
            $request->file('image')->move(public_path('uploads'), $new_img_name);
        }

        // add value
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $new_img_name,
            'status' => $request->status,
        ]);
        return redirect()->route('dashboard.categories.index',compact('categories'))
        ->with('success', 'تم تعديل الفئة بنجاح ');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('dashboard.categories.index')
            ->with('danger', 'تم حذف المبادرة بنجاح !');
    }
}
