@extends('layouts.dashboard')
@section('title')
category
@endsection
@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Category Page</li>
@endsection

@section('content')

<div class="mb-5">
    @if(Auth::user()->can('categories.create'))
    <a href="{{ route('category.create') }}" class="btn btb-sm btn-outline-primary mr-2">create</a>
    @endif
    <a href="{{ route('category.trash') }}" class="btn btb-sm btn-outline-dark">Trash</a>
</div>
{{-- هنا عشان نعرض رسالة علي الصفحة  --}}
<x-alert type="success" />
<x-alert type="info" />

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
            <td>parent_id</td>
            <td>status</td>
            <td>product #</td>
            <td>Category at</td>
            <td colspan="2"></td>
        </tr>
    </thead>
    <tbody>
    @forelse ($categories as $category)

        <tr>
            <td><img src="{{ asset('storage/'.$category->image) }}" alt="" height="50"></td>
            <td>{{ $category->id }}</td>
            <td> <a href="{{ route('category.show',$category->id) }}">{{ $category->name }}</a></td>
            <td>{{ $category->parent->name }}</td>
            <td>{{ $category->status }}</td>
            <td>{{ $category->products_number }}</td>
            <td>{{ $category->created_at }}</td>
            <td>
                @can('categories.update')
            <a href="{{ route('category.edit',$category->id) }}" class="btn btb-sm btn-outline-success">Edit</a>
            @endcan
            </td>
            <td>
                @can('categories.delete')
                <form action="{{ route('category.destroy',$category->id) }}" method="post">
                @csrf
                @method('delete')
                <button  class="btn btb-sm btn-outline-danger" type="submit">Delete</button>
                </form>
                @endcan
            </td>
        </tr>
        @empty
            <td colspan="7">no category</td>
    @endforelse

    </tbody>
</table>

{{-- عشان تفعلها روح علي provider app service
withquerystring() عشان الفلتر البحث يشتغل في كل الصفحات
--}}
{{ $categories->withquerystring()->links() }}
@endsection


