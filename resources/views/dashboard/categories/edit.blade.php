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
            @include('dashboard.categories._form',[
                    'button_label' => 'تعديل'
                ])

        </form>
    </div>
@endsection
