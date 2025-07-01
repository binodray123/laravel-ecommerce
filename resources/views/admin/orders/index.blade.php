@extends('layouts.admin')

@section('content')
<div class="container">
    <h3>All Orders</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th><th>User</th><th>Status</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->status }}</td>
                <td>
                    <a href="{{ route('admin.orders.track', $order->id) }}" class="btn btn-sm btn-primary">Manage Tracking</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
