@extends('dashboard.layouts.master')
@section('title', 'انشاء فئة')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">فئات العمل التطوعي</li>
<li class="breadcrumb-item active">انشاء فئة</li>
@endsection

@section('content')
<div class="content">
    <form action="{{ route('dashboard.categories.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>اسم الفئة</label>
            <input type="text" name="name" class="form-control">
            @error('name')
                <div class="text-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>الصورة</label>
            <input type="file" name="image" class="form-control">
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
        <div class="py-3">
            <button class="btn btn-outline-success">اضافة</button>
        </div>
    </form>
</div>
@endsection
