@extends('dashboard.layouts.master')
@section('title', 'سلة محذوفات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">الاعمال التطوعية</li>
    <li class="breadcrumb-item active">سلة المحذوفات </li>
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
                    <th>الصورة</th>
                    <th>الموقع</th>
                    <th>الحالة</th>
                    <th>تاريخ الانشاء</th>
                    <th>تاريخ التعديل</th>
                    <th colspan="2">الاعدادات</th>
                </tr>
        </thead>
        <tbody>
            @forelse ($posts as $post)
            <tr>
                        <td>{{ $post->id}}</td>
                        <td> {{ $post->title }}</td>
                        <td><img src="{{ asset('storage/' . $post->image) }}" width="120" height="80"> </td>
                        <td>{{ $post->location }}</td>
                        <td>{{ $post->status == 'active' ? 'نشط' : 'أرشيف' }}</td>
                        <td>{{ $post->created_at }}</td>
                        <td>{{ $post->updated_at }}</td>
                        <td>
                        <form action="{{ route('dashboard.posts.restore', $post->id) }}" method="post">
                                @csrf
                                @method('put')
                                <button class="btn btn-sm btn-outline-info">استرجاع</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('dashboard.posts.force-delete', $post->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-outline-danger">حذف</button>
                            </form>
                        </td>
                    </tr>
        </tbody>
    @empty
        <td colspan="7">لا يوجد اعمال تطوعية محذوفة ..</td>
        @endforelse
    </table>

@endsection
