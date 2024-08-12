@extends('layouts.dashboard')
@section('title')
product
@endsection
@section('breadcrumb')
@parent
<li class="breadcrumb-item active">product Page</li>
@endsection

@section('content')

<div class="mb-5">
    <a href="{{ route('product.create') }}" class="btn btb-sm btn-outline-primary mr-2">create</a>
</div>
{{-- هنا عشان نعرض رسالة علي الصفحة  --}}
<x-alert type="success" />

<form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
<x-form.input name="name" :value="request('name')" type="text" placeholder="Name"  class="mx-2"/>
<select name="status" class="form-control mx-2">
<option value="">All</option>
<option value="active" @selected(request('status')=='active')>Active</option>
<option value="archived" @selected(request('status')=='archived')>Archived</option>
</select>
<button class="btn btn-dark mx-2">Filter</button>
</form>


<table class="table">
    <thead>
        <tr>
            <td></td>
            <td>id</td>
            <td>name</td>
            <td>category</td>
            <td>store</td>
            <td>status</td>
            <td>created at</td>
            <td colspan="2"></td>
        </tr>
    </thead>
    <tbody>
    @forelse ($products as $product)

        <tr>
            <td><img src="{{ asset('storage/'.$product->image) }}" alt="" height="50"></td>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->store->name }}</td>
            <td>{{ $product->status }}</td>
            <td>{{ $product->created_at }}</td>
            <td>
            <a href="{{ route('product.edit',$product->id) }}" class="btn btb-sm btn-outline-success">Edit</a>
            </td>
            <td>
                <form action="{{ route('product.destroy',$product->id) }}" method="post">
                @csrf
                @method('delete')
                <button  class="btn btb-sm btn-outline-danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @empty
            <td colspan="9">no product</td>
    @endforelse

    </tbody>
</table>

{{-- عشان تفعلها روح علي provider app service
withquerystring() عشان الفلتر البحث يشتغل في كل الصفحات
--}}
{{ $products->withquerystring()->links() }}
@endsection


