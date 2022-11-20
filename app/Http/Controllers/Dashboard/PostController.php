<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['category'])->latest()->paginate(5);
        return view('dashboard.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $post = new Post();

        return view('dashboard.posts.create', compact('categories', 'post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Post::rules(), [
            'required' => 'هذا الحقل  ايجباري',
            'min' => 'هذا الحقل ',
            'max' => 'هذا الحقل',
            'image' => 'هذا الحقل من نوع صورة'
        ]);

        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);

        $category = Post::create($data);



        return redirect()->route('dashboard.posts.index')
            ->with('success', 'تم انشاء عمل تطوعي بنجاح!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('dashboard.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('dashboard.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(Post::rules($id));

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
        return redirect()->route('dashboard.posts.index')
            ->with('success', 'تم تعديل العمل التطوعي بنجاح!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('dashboard.posts.index')
            ->with('danger', 'تم حذف العمل التطوعي بنجاح!');
    }

    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image'); //UploadFile Object
        $path = $file->store('uploads/posts', [
            'disk' => 'public'
        ]);
        return $path;
    }
    public function trash()
    {
        $posts = Post::onlyTrashed()->paginate(5);
        return  view('dashboard.posts.trash', compact('posts'));
    }

    public function restore(Request $request, $id)
    {
        $category = Post::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.posts.trash')
            ->with('success', 'تم استرجاع العمل التطوعي!');
    }
    public function forceDelete($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->forceDelete();
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        return redirect()->route('dashboard.posts.trash')
            ->with('danger', 'تم حذف العمل التطوعي بشكل نهائي !');
    }
}
