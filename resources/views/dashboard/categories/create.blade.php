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
        @include('dashboard.categories._form',[
            'button_label' => 'اضافة'
            ])
    </form>
</div>
@endsection
