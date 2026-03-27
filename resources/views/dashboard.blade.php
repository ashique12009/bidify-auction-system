@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <h3>Welcome to Dashboard</h3>
    </div>
    
    <div class="card">
        <div class="card-body">
            <h4>Hello, {{ auth()->user()->name }}!</h4>
            <p class="text-muted">You are logged in as: <span class="badge bg-primary">{{ auth()->user()->role }}</span></p>
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="mt-4">
                <h5>Quick Actions:</h5>
                <div class="row">
                    @if(auth()->user()->role === 'admin')
                        <div class="col-md-3">
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-primary w-100 mb-2">Manage Categories</a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-success w-100 mb-2">Manage All Products</a>
                        </div>
                    @endif
                    
                    @if(auth()->user()->role === 'publisher')
                        <div class="col-md-3">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-success w-100 mb-2">My Products</a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('products.create') }}" class="btn btn-outline-info w-100 mb-2">Add New Product</a>
                        </div>
                    @endif
                    
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
            
            @if(auth()->user()->role === 'publisher')
                <div class="mt-4">
                    <h5>Your Products Summary:</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h6 class="card-title">Total Products</h6>
                                    <h4 class="text-primary">{{ \App\Models\Product::where('publisher_id', auth()->id())->count() }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h6 class="card-title">Running</h6>
                                    <h4 class="text-success">{{ \App\Models\Product::where('publisher_id', auth()->id())->where('status', 'running')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h6 class="card-title">Pending</h6>
                                    <h4 class="text-warning">{{ \App\Models\Product::where('publisher_id', auth()->id())->where('status', 'pending')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h6 class="card-title">Ended</h6>
                                    <h4 class="text-danger">{{ \App\Models\Product::where('publisher_id', auth()->id())->where('status', 'ended')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="mt-4">
                <h5>Account Info:</h5>
                <table class="table table-striped">
                    <tr>
                        <th>Name:</th>
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
@endsection
