@extends('manage.admin.index')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold">Add Forum Category</h4>
    <p class="text-muted small">Category is required before players can start posting.</p>
</div>

<form method="post" action="{{ route('forumcontrol.store') }}">
    @csrf

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Category Name --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Category Name</label>
                <input type="text" class="form-control" name="category_name" value="{{ old('category_name') }}">
                @error('category_name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Description</label>
                <textarea class="form-control" rows="6" name="description">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary">
                    Add Category
                </button>
                <button type="reset" class="btn btn-light">
                    Clear
                </button>
            </div>

        </div>
    </div>

</form>

@endsection
