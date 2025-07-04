@extends('layouts.app')
@section('content')
<main class="py-5 text-center">
    <h2>🎉 Payment Successful</h2>
    <p>Your order has been placed successfully.</p>
    <a href="{{ route('home.index') }}" class="btn btn-success mt-3">Continue Shopping</a>
</main>
@endsection
