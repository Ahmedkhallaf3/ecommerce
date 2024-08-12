@extends('layouts.dashboard')
@section('title')
    product Edit
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit categories</li>
@endsection
@section('content')
    <form action="{{ route('product.update',$product->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
   @include('dashboard.product._form',['button_label'=> 'Update'])
</form>
@endsection
