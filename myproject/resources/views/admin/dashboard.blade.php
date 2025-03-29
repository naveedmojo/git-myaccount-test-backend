@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <h2>Admin Dashboard</h2>
    <p>Manage your products, categories, messages, and reports from here.</p>

    <!-- Dashboard Statistics -->
    <div class="row mt-4">
        <div class="col-12 col-md-3 mb-3">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Sales</h5>
                    <p class="card-text fs-3">{{ $totalSales ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Inquiries</h5>
                    <p class="card-text fs-3">{{ $totalInquiries ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text fs-3">{{ \App\Models\Product::totalProducts() }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <div class="card text-white bg-danger shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Categories</h5>
                     <p class="card-text fs-3">{{ \App\Models\SubCategory::getTotalSubCategories() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Row for Total Profit -->
    <div class="row mt-4">
        <div class="col-12 col-md-3 mb-3">
            <div class="card text-white bg-dark shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Profit</h5>
                    <p class="card-text fs-3">${{ number_format($totalProfit ?? 0, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
