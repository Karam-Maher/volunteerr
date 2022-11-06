@extends('dashboard.layouts.master')
@section('title', 'المنشورات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">المنشورات</li>
@endsection

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('danger'))
        <div class="alert alert-danger" role="alert">
            {{ session('danger') }}
        </div>
    @endif
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>العنوان</th>
                    <th>الوصف</th>
                    <th>الصورة</th>
                    <th>فئة العمل التطوعي</th>
                    <th>الموقع</th>
                    <th>الحالة</th>
                    <th>تاريخ الانشاء</th>
                    <th>تاريخ التعديل</th>
                    <th colspan="2">الاعدادات</th>
                </tr>
            </thead>
            <tbody>
            @php
            $i = 1;
            @endphp
                @forelse ($posts as $post)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->description }}</td>
                        <td><img src="{{asset('uploads/' . $post->image)}}" width="100">   </td>
                        <td>{{ $post->category_id }}</td>
                        <td>{{ $post->location }}</td>
                        <td>{{ $post->status == 'active' ? 'نشط' : 'أرشيف' }}</td>
                        <td>{{ $post->created_at }}</td>
                        <td>{{ $post->updated_at }}</td>
                        <td>
                            <a href="{{ route('dashboard.posts.edit', $post->id) }}"
                                class="btn btn-sm btn-outline-info">تعديل</a>
                        </td>
                        <td>
                            <form action="{{ route('dashboard.posts.destroy', $post->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-outline-danger">حذف</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
                @empty
                    <td colspan="9">لا يوجد منشورات ..</td>
                @endforelse
        </table>
@endsection
