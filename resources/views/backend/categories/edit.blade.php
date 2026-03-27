@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Category</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control @error('category_name') is-invalid @enderror" 
                                   id="category_name" name="category_name" value="{{ old('category_name', $category->category_name) }}" required>
                            @error('category_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_image" class="form-label">Category Image</label>
                            <input type="file" class="form-control @error('category_image') is-invalid @enderror" 
                                   id="category_image" name="category_image" accept="image/*">
                            @error('category_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Optional: Upload new category image (JPEG, PNG, JPG, GIF - Max 2MB)</div>
                            
                            @if($category->category_image)
                                <div class="mt-2">
                                    <small class="text-muted">Current Image:</small><br>
                                    <img src="{{ asset('storage/' . $category->category_image) }}" 
                                         alt="{{ $category->category_name }}" style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
