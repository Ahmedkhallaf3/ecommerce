@extends('layouts.dashboard')
@section('title')
    {{ $category->name }}
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Category Page</li>
    <li class="breadcrumb-item active">{{ $category->name }}</li>
@endsection

@section('content')
<table class="table">
    <thead>
        <tr>
            <th>image</th>
            <th>Name</th>
            <th>store</th>
            <th>status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
    @php
        $products=$category->products()->with('store')->latest()->paginate(5)
    @endphp
        @forelse ($products as $product)

            <tr>
                <td><img src="{{ asset('storage/'.$product->image) }}" alt="" height="50"></td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->store->name }}</td>
                <td>{{ $product->status }}</td>
                <td>{{ $product->created_at }}</td>


            </tr>
            @empty
                <td colspan="5">no product</td>
        @endforelse

        </tbody>
    </table>

    {{-- عشان تفعلها روح علي provider app service
    withquerystring() عشان الفلتر البحث يشتغل في كل الصفحات
    --}}
    {{ $products->withquerystring()->links() }}


@endsection
