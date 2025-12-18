@php
    $settings = \App\GeneralSettings::first();
@endphp

@extends('layouts.app')

@section('title', 'Forum - ' . ($topics->count() > 0 ? $topics[0]->category->forum_category_name : 'Category'))

@push('styles')
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

    .topic-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        transition: all 0.4s ease;
    }

    .topic-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    }

    .category-badge {
        background: var(--primary);
        color: white;
        padding: 0.8rem 2rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.1rem;
        box-shadow: 0 0 25px rgba(108,92,231,0.5);
        display: inline-block;
    }
</style>
@endpush

@section('content')

{{-- Hero - same as all other pages --}}
<div class="hero-section text-white text-center position-relative">
    <div class="container position-relative">
        <h1 class="display-3 fw-bold text-uppercase mb-3">FORUMS</h1>
        <h5 class="fw-light fs-3 opacity-90">{{ $settings->website_name }} Community</h5>
    </div>
</div>

<div class="container my-5">

    {{-- Buttons --}}
    <div class="d-flex justify-content-end mb-5 gap-3 flex-wrap">
        <a href="{{ route('topic.create') }}" class="btn btn-primary px-5 py-3 fw-bold">
            Add New Topic
        </a>
        <a href="{{ route('topicmanager.index') }}" class="btn btn-outline-light border-2 px-5 py-3 fw-bold">
            My Topics
        </a>
    </div>

    {{-- Category Header --}}
    <div class="text-center mb-5">
        @if($topics->count() > 0)
            <div class="category-badge mb-4">
                {{ $topics[0]->category->forum_category_name }}
            </div>
            <h1 class="display-4 fw-bold mb-4">{{ $topics[0]->category->forum_category_name }}</h1>
            <p class="lead text-white fs-5 px-3">
                {!! $topics[0]->category->forum_category_description ?? 'Join the discussion and share your thoughts!' !!}
            </p>
        @else
        <div class="text-center py-5">
    <i class="fas fa-folder-open fa-5x mb-4" style="color: #6c757d; opacity: 0.7;"></i>
    <h2 class="text-white fw-bold mb-3" style="text-shadow: 0 2px 10px rgba(0,0,0,0.6);">This category is empty</h2>
    <p class="text-light fs-4 opacity-90">Be the first to create a topic!</p>
</div>
        @endif
    </div>

    <div class="row g-5">
        {{-- Topics List --}}
        <div class="col-lg-9">
            @forelse($topics as $topic)
                <div class="topic-card card shadow mb-4">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-3">
                            <a href="{{ route('topic.show', $topic->topic_id) }}" class="text-decoration-none text-primary">
                                {{ $topic->topic_title }}
                            </a>
                        </h3>
                        <div class="text-dark opacity-90 lh-lg mb-4 fs-5">
                            {!! Str::limit(strip_tags($topic->topic_content), 300) !!}
                        </div>
                        <div class="d-flex flex-wrap gap-4 text-muted small">
                            <span>By <strong>{{ optional($topic->user)->name ?? 'Guest' }}</strong></span>
                            <span>{{ $topic->topic_views }} views</span>
                            <span>{{ $topic->comments->count() }} replies</span>
                            <span>{{ $topic->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-6">
                    <i class="fas fa-inbox fa-6x text-muted opacity-25 mb-4"></i>
                    <h4 class="text-white">No topics yet</h4>
                </div>
            @endforelse

            <div class="mt-5 d-flex justify-content-center">
                {{ $topics->onEachSide(2)->links() }}
            </div>
        </div>

        {{-- Sidebar - white card, readable --}}
        <div class="col-lg-3">
            <div class="card shadow-lg border-0 sticky-top content-card" style="top: 100px;">
                <div class="card-header text-white text-center fw-bold py-4" style="background: var(--primary); border-radius: 20px 20px 0 0;">
                    Forum Categories
                </div>
                <div class="card-body p-4 bg-white">
                    @foreach($categories as $category)
                        <a href="{{ route('forumcategory.show', $category->forum_category_id) }}"
                           class="d-block text-decoration-none py-3 px-4 rounded mb-2 fw-bold
                                  {{ request()->route('id') == $category->forum_category_id ? 'bg-primary text-white' : 'text-dark bg-light' }}">
                            {{ $category->forum_category_name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection