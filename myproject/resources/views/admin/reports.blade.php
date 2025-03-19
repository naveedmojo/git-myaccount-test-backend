@extends('admin.layout')

@section('title', 'Reports')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Sales & Analytics Reports</h2>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Sales</h5>
                        <p class="fs-3 text-primary">{{ $totalSales ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Inquiries</h5>
                        <p class="fs-3 text-success">{{ $totalInquiries ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
