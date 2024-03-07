@extends('layouts.dashboard')

@section('title', 'Admins')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Admins</li>
@endsection

@section('content')

    <form action="{{ route('dashboard.admins.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        @include('dashboard.admins._form')
    </form>

@endsection
