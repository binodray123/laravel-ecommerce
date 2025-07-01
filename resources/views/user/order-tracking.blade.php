@extends('layouts.app')

@section('content')
<style>
    .card {
        background: white;
        padding: 20px;
        margin: 50px auto;
        width: 600px;
        border-radius: 10px;
    }

    .status-bar {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
    }

    .step {
        text-align: center;
        flex: 1;
        color: #999;
    }

    .step.active {
        color: green;
        font-weight: bold;
    }

    .scan-entry {
        border-left: 2px solid #ccc;
        margin: 10px 0;
        padding-left: 10px;
    }
</style>
<main class="pt-90" style="padding-top: 0px;">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Orders Tracking</h2>
        <div class="row">
            <div class="col-lg-2">
                @include('user.account-nav')
            </div>

            <div class="card">
                <h3>Tracking Order #{{ $order->id }}</h3>
                <p>User: {{ $order->user->name }} ({{ $order->user->email }})</p>

                @php
                $statusSteps = [
                'Processing' => $order->created_at,
                'Shipped' => $order->shipped_date,
                'Out for Delivery' => $order->out_for_delivery_date,
                'Canceled' => $order->canceled_date,
                'Delivered' => $order->delivered_date,
                ];

                // Filter only available statuses
                $filteredSteps = collect($statusSteps)->filter();

                // Group by date
                $groupedByDate = $filteredSteps->groupBy(fn($timestamp) =>
                \Carbon\Carbon::parse($timestamp)->format('d M Y')
                );
                @endphp

                <div class="status-bar">
                    @foreach(array_keys($statusSteps) as $step)
                    @if($statusSteps[$step])
                    <div class="step active">
                        ✔ {{ $step }}
                    </div>
                    @else
                    <div class="step">
                        {{ $step }}
                    </div>
                    @endif
                    @endforeach
                </div>

                @foreach($groupedByDate as $date => $timestamps)
                <h4>{{ $date }}</h4>
                @foreach($timestamps as $timestamp)
                @php
                $stepName = $filteredSteps->first(function($value, $key) use ($timestamp) {
                return $value == $timestamp;
                });

                $stepLabel = $filteredSteps->search($timestamp); // returns status name

                $location = $order->address ?? 'N/A';
                $state = $order->state ?? '';
                @endphp
                <div class="scan-entry">
                    <strong>{{ \Carbon\Carbon::parse($timestamp)->format('h:i A') }}</strong><br>
                    {{ $stepLabel }}<br>
                    <em>{{ $location }} ({{ $state }})</em>
                </div>
                @endforeach
                @endforeach
            </div>
        </div>
    </section>
</main>


@endsection
