@extends('admin.layout')

@section('title', 'Messages')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Customer Messages</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                {{-- Sample Data for Testing --}}
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>john@example.com</td>
                    <td>Interested in PS5 availability.</td>
                    <td>2025-03-19</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jane Smith</td>
                    <td>jane@example.com</td>
                    <td>Requesting a bulk order.</td>
                    <td>2025-03-18</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
