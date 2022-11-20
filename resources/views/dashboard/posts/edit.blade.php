@extends('dashboard.layouts.master')
@section('title', 'تعديل العمل')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">الاعمال التطوعية</li>
    <li class="breadcrumb-item active">تعديل العمل</li>
@endsection

@section('content')
    <div class="content">
        <form action="{{ route('dashboard.posts.update' ,$post->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('dashboard.posts._form',[
            'button_label' => 'تعديل'
            ])
        </form>
    </div>
@endsection
