@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Product Details</h3>
                    <div>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($product->product_image)
                                <img src="{{ asset('uploads/products/' . $product->product_image) }}" 
                                     alt="{{ $product->product_name }}" class="img-fluid rounded">
                            @else
                                <div class="text-center text-muted bg-light p-5 rounded">
                                    No Image Available
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h4>{{ $product->product_name }}</h4>
                            <p class="text-muted">Category: {{ $product->category->category_name }}</p>
                            
                            <div class="mb-3">
                                <span class="badge bg-{{ $product->status == 'running' ? 'success' : ($product->status == 'ended' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </div>

                            @if($product->description)
                                <div class="mb-3">
                                    <h5>Description:</h5>
                                    <p>{{ $product->description }}</p>
                                </div>
                            @endif

                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Start Price:</th>
                                    <td>${{ number_format($product->start_price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Current Price:</th>
                                    <td class="text-success fw-bold">${{ number_format($product->current_price, 2) }}</td>
                                </tr>
                                @if($product->start_time)
                                <tr>
                                    <th>Start Time:</th>
                                    <td>{{ $product->start_time->format('M d, Y h:i A') }}</td>
                                </tr>
                                @endif
                                @if($product->end_time)
                                <tr>
                                    <th>End Time:</th>
                                    <td>{{ $product->end_time->format('M d, Y h:i A') }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Created:</th>
                                    <td>{{ $product->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated:</th>
                                    <td>{{ $product->updated_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
