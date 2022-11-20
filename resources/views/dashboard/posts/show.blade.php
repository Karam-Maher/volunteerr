@extends('dashboard.layouts.master')
@section('title', $post->title)

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">الاعمال التطوعية</li>
    <li class="breadcrumb-item active">{{$post->title}}</li>

@endsection

@section('content')
        <table class="table">
            <thead>
                <tr>
                    <th>العنوان</th>
                    <th>الوصف</th>
                    <th>الصورة</th>
                    <th>الموقع</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>


                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->description }}</td>
                        <td><img src="{{ asset('storage/' . $post->image) }}" width="120" height="80"> </td>
                        <td>{{ $post->location }}</td>
                        <td>{{ $post->status == 'active' ? 'نشط' : 'أرشيف' }}</td>
                    </tr>
                </tbody>

        </table>
@endsection
