@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Welcome to Dashboard</h3>
                </div>
                <div class="card-body">
                    <h4>Hello, {{ auth()->user()->name }}!</h4>
                    <p class="text-muted">You are logged in as: <span class="badge bg-primary">{{ auth()->user()->role }}</span></p>
                    
                    <div class="mt-4">
                        <h5>Quick Actions:</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <a href="{{ route('categories.index') }}" class="btn btn-outline-primary w-100 mb-2">Manage Categories</a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-success w-100 mb-2">Manage Products</a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('welcome') }}" class="btn btn-outline-info w-100 mb-2">View Site</a>
                            </div>
                            <div class="col-md-3">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger w-100 mb-2">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Your Account Info:</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th width="150">Name:</th>
                                <td>{{ auth()->user()->name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ auth()->user()->email }}</td>
                            </tr>
                            <tr>
                                <th>Role:</th>
                                <td><span class="badge bg-primary">{{ auth()->user()->role }}</span></td>
                            </tr>
                            <tr>
                                <th>Joined:</th>
                                <td>{{ auth()->user()->created_at->format('M d, Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
