@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Available Products</h5>
                        <h2 class="card-text">{{$totalProducts}}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <h5 class="card-title">Total Profit</h5>
                        <h2 class="card-text">{{$totalProfit}}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Product Sold</h5>
                        <h2 class="card-text">{{$totalSellQty}}</h2>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
