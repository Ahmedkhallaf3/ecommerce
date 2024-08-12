@extends('layouts.dashboard')
@section('title')
    category Edit
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Category Page</li>
@endsection

@section('content')
    <form action="{{ route('category.update',$category->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('dashboard.category._form',['button_label'=>'update'])


    </form>
@endsection
