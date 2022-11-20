@extends('dashboard.layouts.master')
@section('title', 'انشاء عمل')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">الاعمال التطوعية</li>
    <li class="breadcrumb-item active">انشاء عمل</li>
@endsection

@section('content')
    <div class="content">
        <form action="{{ route('dashboard.posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @include('dashboard.posts._form',[
            'button_label' => 'اضافة'
            ])
        </form>
    </div>
@endsection
