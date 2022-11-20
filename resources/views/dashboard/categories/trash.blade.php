@extends('dashboard.layouts.master')
@section('title', 'سلة محذوفات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">فئات العمل التطوعي</li>
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
                <th>اسم الفئة</th>
                <th>صورة الفئة</th>
                <th>حالة الفئة</th>
                <th>تاريخ الانشاء</th>
                <th>تاريخ الحذف</th>
                <th colspan="2">الاعدادات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td><img src="{{ asset('storage/' . $category->image) }}" width="120" height="80"> </td>
                    <td>{{ $category->status == 'active' ? 'نشط' : 'أرشيف' }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td>{{ $category->deleted_at }}</td>
                    <td>
                    <form action="{{ route('dashboard.categories.restore', $category->id) }}" method="post">
                            @csrf
                            @method('put')
                            <button class="btn btn-sm btn-outline-info">استرحاع</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('dashboard.categories.force-delete', $category->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-outline-danger">حذف</button>
                        </form>
                    </td>
                </tr>
        </tbody>
    @empty
        <td colspan="7">لا يوجد أقسام ..</td>
        @endforelse
    </table>

    {{ $categories->withQueryString()->appends(['search' => 1])->links() }}
@endsection
