@extends('layouts.dashboard')
@section('title')
    category
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Category Page</li>
@endsection

@section('content')
    <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('dashboard.category._form')




    </form>
@endsection
