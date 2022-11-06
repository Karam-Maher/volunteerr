<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $posts = Post::paginate(5);
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
        return view('dashboard.posts.create', compact('categories'));
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
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:8',
            'location' => 'required|string|min:3|max:255',
            'status' => ['in:active,archived'],
        ], [
            'required' => 'هذا الحقل مطلوب',
            'image' => 'هذا الحقل من نوع صورة',
            'string' => 'هذا الحقل من نوع نصي',
        ])->validate();

        $ex = $request->file('image')->getClientOriginalExtension();
        $new_img_name = 'posts_p'.time() . '.' . $ex;
        $request->file('image')->move(public_path('uploads'), $new_img_name);

        // $posts = Post::create($request->all());
        Post::create([
            'title' => $request->title,
            'description' =>$request->description,
            'image' => $new_img_name,
            'location' => $request->location,
            'status' => $request->status,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('dashboard.posts.index')
            ->with('success', 'تم انشاء منشور بنجاح!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('dashboard.posts.show', [
            'category' => $post
        ]);
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
        return view('dashboard.posts.edit', compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Post $post)
    {
        Validator::make($request->all(), [
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:8',
            'location' => 'required|string|min:3|max:255',
            'status' => ['in:active,archived'],
        ], [
            'required' => 'هذا الحقل مطلوب',
            'image' => 'هذا الحقل من نوع صورة',
            'string' => 'هذا الحقل من نوع نصي',
        ])->validate();

        $new_img_name = $post->image;
        if($request->has('image')) {
            // Upload image
            $ex = $request->file('image')->getClientOriginalExtension();
            $new_img_name = 'posts_p'.time() . '.' . $ex;
            $request->file('image')->move(public_path('uploads'), $new_img_name);
        }
        $post->update([
            'title' => $request->title,
            'description' =>$request->description,
            'image' => $new_img_name,
            'location' => $request->location,
            'status' => $request->status,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('dashboard.posts.index')
            ->with('success', 'تم تعديل المنشور بنجاح!');
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
            ->with('danger', 'تم حذف المنشور بنجاح!');
    }
}
