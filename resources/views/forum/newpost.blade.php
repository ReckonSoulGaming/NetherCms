

@extends('layouts.app')

@section('title', 'Create New Topic')

{{-- Extra CSS only for this page --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

@endpush

{{-- Extra JS only for this page --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Write your content here...',
            tabsize: 2,
            height: 350,
            focus: true,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endpush

@section('content')
{{-- Hero Section --}}
<div class="hero-section text-white text-center position-relative">
    <div class="container position-relative">
        <h1 class="display-3 fw-bold text-uppercase mb-3">FORUMS</h1>
        <h5 class="fw-light fs-3 opacity-90">{{ $settings->website_name }} Community</h5>
    </div>
</div>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <div class="card shadow-lg border-0 card-hover">
                <div class="card-body p-5 p-lg-6">

                    <div class="text-center mb-5">
                        <h2 class="fw-bold text-uppercase" style="background: linear-gradient(45deg, var(--primary), #00d4ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            Create New Topic
                        </h2>
                        <p class="text-muted fs-5">Posting as <strong>{{ Auth::user()->name }}</strong></p>
                    </div>

                    <form action="{{ route('topic.store') }}" method="POST">
                        @csrf

                        {{-- Category --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                            <select name="category" class="form-select form-select-lg @error('category') is-invalid @enderror" required>
                                <option value="">Choose a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->forum_category_id }}"
                                        {{ old('category') == $category->forum_category_id ? 'selected' : '' }}>
                                        {{ $category->forum_category_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Title --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="topic" class="form-control form-control-lg @error('topic') is-invalid @enderror"
                                   value="{{ old('topic') }}" placeholder="Enter a catchy title..." required>
                            @error('topic')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Content - Summernote --}}
                        <div class="mb-5">
                            <label class="form-label fw-bold">Content <span class="text-danger">*</span></label>
                            <textarea name="content" id="summernote" class="@error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="is_published" value="1">

                        {{-- Submit Button --}}
                        <div class="text-center">
                            <button type="submit" class="btn btn-create text-white fw-bold px-5 py-3">
                                <i class="fas fa-paper-optione me-2"></i>
                                Publish Topic
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection