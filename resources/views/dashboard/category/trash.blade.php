@extends('layouts.dashboard')
@section('title')
category trash
@endsection
@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Category trash Page</li>
@endsection

@section('content')

<div class="mb-5">
    <a href="{{ route('category.index') }}" class="btn btb-sm btn-outline-primary">back</a>
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
            <td>status</td>
            <td>deleted at</td>
            <td colspan="2"></td>
        </tr>
    </thead>
    <tbody>
    @forelse ($categories as $category)

        <tr>
            <td><img src="{{ asset('storage/'.$category->image) }}" alt="" height="50"></td>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->status }}</td>
            <td>{{ $category->deleted_at }}</td>
            <td>
                <form action="{{ route('category.restore',$category->id) }}" method="post">
                    @csrf
                    @method('put')
                    <button  class="btn btb-sm btn-outline-info" type="submit">restore</button>
                    </form>
            </td>
            <td>
                <form action="{{ route('category.forceDelete',$category->id) }}" method="post">
                @csrf
                @method('delete')
                <button  class="btn btb-sm btn-outline-danger" type="submit">Delete</button>
                </form>
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


