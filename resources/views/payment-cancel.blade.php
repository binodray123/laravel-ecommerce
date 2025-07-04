@extends('layouts.app')
@section('content')
<main class="py-5 text-center">
    <h2>❌ Payment Cancelled</h2>
    <p>Your payment was cancelled. Please try again or choose another method.</p>
    <a href="{{ route('cart.index') }}" class="btn btn-warning mt-3">Back to Cart</a>
</main>
@endsection
