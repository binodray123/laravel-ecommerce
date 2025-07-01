@extends('layouts.admin')

@section('content')
<div class="wg-box mt-5">
    <h3>Tracking Order #{{ $order->id }} - {{ $order->user->name }}</h3>

    <form method="POST" action="{{ route('admin.orders.track.store', $order->id) }}">
        @csrf
        <div class="row ">
            <div class="col-md-3">
                <!-- <input type="text" name="status" value="{{$order->status}}" placeholder="Status" class="form-control" required> -->
                <label for="">Status</label>
                <select name="order_status" id="order_status">
                    <option value="ordered" {{$order->status == 'ordered' ? "selected":""}}>Ordered</option>
                    <option value="delivered" {{$order->status == 'delivered' ? "selected":""}}>Delivered</option>
                    <option value="canceled" {{$order->status == 'canceled' ? "selected":""}}>Canceled</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="">Location</label>
                <input type="text" name="location" placeholder="Location" value="{{$order->address}}" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="">State</label>
                <input type="text" name="state" placeholder="State" value="{{$order->state}}" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="">Date</label>
                <input type="datetime-local" name="scan_time" class="form-control" required>
            </div>

        </div><br>
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary tf-button w208">Add Scan</button>
        </div>
    </form>

    <h5>Scan History</h5>
    <ul class="list-group">
        @foreach($scans as $scan)
        <li class="list-group-item">
            <strong>{{ $scan->status }}</strong> –
            {{ $scan->location }} ({{ $scan->state }}) –
            {{ \Carbon\Carbon::parse($scan->scan_time)->format('d M Y, h:i A') }}
        </li>
        @endforeach
    </ul>
</div>
@endsection
