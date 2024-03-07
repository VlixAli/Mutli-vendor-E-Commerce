@php use Illuminate\Support\Facades\URL; @endphp
@extends('layouts.dashboard')

@section('title', 'Trashed Admins')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Admins</li>
    <li class="breadcrumb-item active">Trash</li>
@endsection

@section('content')

    <div class="mb-5">
        <a href="{{ route('dashboard.admins.index') }}" class="btn btn-sm btn-outline-primary">Back</a>
    </div>

    <x-alert type="success"/>
    <x-alert type="info"/>

    <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')"/>
        <select name="status" class="form-control mx-2">
            <option value="">All</option>
            <option value="active" @selected(request('status') == 'active')>Active</option>
            <option value="archived" @selected(request('status') == 'archived')>Archived</option>
        </select>
        <button class="btn btn-dark">Filter</button>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Deleted At</th>
            <th colspan="2"></th>
        </tr>
        </thead>
        <tbody>
        @forelse($admins as $admin)
            <tr>
                <td><img src="{{asset('storage/'.$admin->image)}}" alt="" height="50"></td>
                <td>{{ $admin->id }}</td>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->status }}</td>
                <td>{{ $admin->deleted_at }}</td>
                <td>
                    <form action="{{ route('dashboard.admins.restore', $admin->id) }}" method="post">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn btn-sm btn-outline-info">Restore</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('dashboard.admins.force-delete', $admin->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No admins defined.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    {{$admins->links()}}
@endsection
