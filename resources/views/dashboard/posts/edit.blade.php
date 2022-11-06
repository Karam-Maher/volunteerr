@extends('dashboard.layouts.master')
@section('title', 'انشاء منشور')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">المنشورات</li>
    <li class="breadcrumb-item active">تعديل منشور</li>
@endsection

@section('content')
    <div class="content">
        <form action="{{ route('dashboard.posts.update' ,$post->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>العنوان</label>
                <input type="text" name="title" class="form-control" value="{{old('title',$post->title)}}">
                @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>الوصف</label>
                <textarea name="description" class="form-control" cols="30">{{old('description',$post->description)}}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>فئة العمل التطوعي</label>
                <select name="category_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;"
                    data-select2-id="1" tabindex="-1" aria-hidden="true">
                    <option selected="selected" value="">اختار الفئة</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected($post->category_id == $category->id )>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>الموقع الجغرافي</label>

                <input type="text" name="location" class="form-control" value="{{old('location',$post->location)}}">
                @error('location')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" value="active" @checked($post->status == 'active')>
                <label class="form-check-label">
                    نشط
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" value="archived" @checked($post->status == 'archived')>
                <label class="form-check-label">
                    أرشيف
                </label>
            </div>
            <div class="form-group">
                <label>الصورة</label>
                <input type="file" name="image" class="form-control">
                <img width="200" class="mt-1" src="{{ asset('uploads/' . $post->image) }}" alt="">
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="py-3">
                <button class="btn btn-outline-success">تعديل</button>
            </div>
        </form>
    </div>
@endsection
