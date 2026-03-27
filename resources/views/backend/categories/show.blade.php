@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Category Details</h3>
                    <div>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($category->category_image)
                                <img src="{{ asset('storage/' . $category->category_image) }}" 
                                     alt="{{ $category->category_name }}" class="img-fluid rounded">
                            @else
                                <div class="text-center text-muted bg-light p-5 rounded">
                                    No Image Available
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">ID:</th>
                                    <td>{{ $category->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $category->category_name }}</td>
                                </tr>
                                <tr>
                                    <th>Products Count:</th>
                                    <td>{{ $category->products()->count() }}</td>
                                </tr>
                                <tr>
                                    <th>Created:</th>
                                    <td>{{ $category->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated:</th>
                                    <td>{{ $category->updated_at->format('M d, Y h:i A') }}</td>
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
