@extends('dashboard.layouts.master')
@section('title', 'تعديل الفئة')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">فئات العمل التطوعي</li>
    <li class="breadcrumb-item active">تعديل الفئة</li>
@endsection

@section('content')
    <div class="content">
        <form action="{{ route('dashboard.categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>العنوان</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" value="active" @checked($category->status == 'active')>
                <label class="form-check-label">
                    نشط
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" value="archived" @checked($category->status == 'archived')>
                <label class="form-check-label">
                    أرشيف
                </label>
            </div>
            <div class="form-group">
                <label>الصورة</label>
                <input type="file" name="image" class="form-control">
                <img width="200" class="mt-1" src="{{ asset('uploads/' . $category->image) }}" alt="">
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
