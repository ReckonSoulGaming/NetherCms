@php
    $settings = \App\GeneralSettings::first();
@endphp

@extends('layouts.app')

@section('title', 'Edit Topic - ' . $topic->topic_title)

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<style>
  

    .content-card {
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.4);
        overflow: hidden;
    }

    .content-card .card-body {
        background: white;
        color: #212529;
    }

    .form-control, .form-select, .note-editor {
        border-radius: 16px !important;
    }

    .btn-save {
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 14px 40px;
        font-weight: 700 1.1rem 'Poppins', sans-serif;
        box-shadow: 0 10px 30px rgba(108,92,231,0.4);
        transition: all 0.3s;
    }

    .btn-save:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 40px rgba(108,92,231,0.6);
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Edit your content here...',
            height: 380,
            focus: true,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });
</script>
@endpush

@section('content')

{{-- Hero - same as topic.show and create topic --}}
<div class="hero-section text-white text-center position-relative">
    <div class="container position-relative">
        <h1 class="display-3 fw-bold text-uppercase mb-3">FORUMS</h1>
        <h5 class="fw-light fs-3 opacity-90">{{ $settings->website_name }} Community</h5>
    </div>
</div>

<div class="container my-5">

    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-10">

            {{-- Edit Form - white card, fully readable --}}
            <div class="content-card shadow-lg">
                <div class="card-header py-4 text-white text-center fw-bold" style="background: var(--primary);">
                    <h3 class="mb-0">Edit Topic</h3>
                    <p class="mb-0 mt-2 opacity-90">Editing as <strong>{{ Auth::user()->name }}</strong></p>
                </div>

                <div class="card-body p-5 p-xl-6">
                    <form action="{{ route('topic.update', $topic->topic_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Category --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold fs-5">Category <span class="text-danger">*</span></label>
                            <select name="category" class="form-select form-select-lg @error('category') is-invalid @enderror" required>
                                <option value="">Choose a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->forum_category_id }}"
                                        {{ old('category', $topic->topic_category_id) == $category->forum_category_id ? 'selected' : '' }}>
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
                            <label class="form-label fw-bold fs-5">Title <span class="text-danger">*</span></label>
                            <input type="text" name="topic"
                                   class="form-control form-control-lg @error('topic') is-invalid @enderror"
                                   value="{{ old('topic', $topic->topic_title) }}"
                                   placeholder="Enter topic title..." required>
                            @error('topic')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Content --}}
                        <div class="mb-5">
                            <label class="form-label fw-bold fs-5">Content <span class="text-danger">*</span></label>
                            <textarea name="content" id="summernote" class="@error('content') is-invalid @enderror">
                                {{ old('content', $topic->topic_content) }}
                            </textarea>
                            @error('content')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="text-center">
                            <button type="submit" class="btn btn-save">
                                Save Changes
                            </button>
                            <a href="{{ route('topic.show', $topic->topic_id) }}" class="btn btn-outline-secondary btn-lg px-5 ms-3">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection