@extends('dashboard.layouts.master')
@section('title', 'انشاء منشور')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">المنشورات</li>
    <li class="breadcrumb-item active">انشاء منشور</li>
@endsection

@section('content')
    <div class="content">
        <form action="{{ route('dashboard.posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>العنوان</label>
                <input type="text" name="title" class="form-control">
                @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>الوصف</label>
                <textarea name="description" class="form-control" cols="30"></textarea>
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
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>الموقع الجغرافي</label>

                <input type="text" name="location" class="form-control">
                @error('location')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" value="active" checked>
                <label class="form-check-label">
                    نشط
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" value="archived">
                <label class="form-check-label">
                    أرشيف
                </label>
            </div>
            <div class="form-group">
                <label>الصورة</label>
                <input type="file" name="image" class="form-control">
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="py-3">
                <button class="btn btn-outline-success">اضافة</button>
            </div>
        </form>
    </div>
@endsection
