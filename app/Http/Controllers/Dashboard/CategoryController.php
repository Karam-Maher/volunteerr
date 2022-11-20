<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\categoryRequest;
use Illuminate\Support\Facades\Storage;
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
        $request = request();

        $categories = Category::withCount('posts')->filter($request->query())
            ->latest()->paginate(4);
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();
        return view('dashboard.categories.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Category::rules(), [
            'required' => 'هذا الحقل  ايجباري',
            'min' => 'هذا الحقل ',
            'max' => 'هذا الحقل',
            'unique' => 'هذا الحقل يجب ان لا يتكرر',
            'image' => 'هذا الحقل من نوع صورة'
        ]);

        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);

        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);

        $category = Category::create($data);

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
        return view('dashboard.categories.show',[
            'category' => $category
        ]);
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required','string','min:3','max:255',"unique:categories,name,$id"],
            'image' => 'nullable|image',
            'status' => 'in:active,archived',
        ]);

        $category = Category::findOrFail($id);
        $old_image = $category->image;

        $data = $request->except('image');

        $new_image = $this->uploadImage($request);

        if ($new_image) {
            $data['image'] = $new_image;
        }

        $category->update($data);

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('dashboard.categories.index')
            ->with('danger', 'تم تعديل المبادرة بنجاح !');
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

        // if ($category->image) {
        //     Storage::disk('public')->delete($category->image);
        // }

        return redirect()->route('dashboard.categories.index')
            ->with('danger', 'تم حذف المبادرة بنجاح !');
    }

    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image'); //UploadFile Object
        $path = $file->store('uploads/categories', [
            'disk' => 'public'
        ]);
        return $path;
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate(5);
        return  view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.categories.trash')
            ->with('success', 'تم استرجاع الفئة!');
    }
    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        return redirect()->route('dashboard.categories.trash')
            ->with('danger', 'تم حذف الفئة بشكل نهائي !');
    }
}
