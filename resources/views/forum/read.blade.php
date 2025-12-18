

@extends('layouts.app')

@section('title', $topic->topic_title)

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
    .comment-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Write your reply here...',
            height: 220,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol']],
                ['insert', ['link', 'picture']],
                ['view', ['codeview']]
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
        <div class="col-xl-10 col-lg-11">

            {{-- Main Topic! --}}
            <div class="content-card shadow-lg mb-5">
                <div class="card-header py-4 text-white text-center fw-bold" style="background: var(--primary);">
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <span class="badge bg-light text-dark">Published</span>
                        <span class="badge bg-white text-primary">{{ $topic->topic_views }} Views</span>
                        <span class="badge bg-light text-dark">{{ $topic->category->forum_category_name }}</span>
                    </div>
                </div>
                <div class="card-body p-5">
                    <h1 class="display-5 fw-bold mb-4">{{ $topic->topic_title }}</h1>
                    <div class="d-flex justify-content-between text-muted small mb-4">
                        <span>By <strong class="text-primary">{{ optional($topic->Author)->name ?? 'Guest' }}</strong> • {{ $topic->created_at->diffForHumans() }}</span>
                        <span>{{ $topic->created_at->format('d M Y • H:i') }}</span>
                    </div>
                    <div class="content fs-5 lh-lg text-dark">
                        {!! $topic->topic_content !!}
                    </div>

                    @auth
                        @if(Auth::id() === $topic->topic_author_id)
                            <div class="text-end mt-4">
                                <a href="{{ route('topic.edit', $topic) }}" class="btn btn-outline-primary me-2">Edit</a>
                                <form method="POST" action="{{ route('topic.destroy', $topic) }}" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Delete forever?')">Delete</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Replies Title --}}
            <h3 class="fw-bold mb-4">
                Replies <span style="color: var(--primary);">({{ $topic->comments->count() }})</span>
            </h3>

            {{-- Comments - white cards, readable --}}
            @forelse($topic->comments as $i => $comment)
                <div class="comment-card card mb-4 shadow">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <strong style="color: var(--primary);">#{{ $i + 1 }}</strong>
                                    @if($topic->topic_author_id == $comment->user_id)
                                        <span class="badge bg-danger text-white small fw-bold">AUTHOR</span>
                                    @endif
                                    <strong>{{ optional($comment->author)->name ?? 'Deleted User' }}</strong>
                                    <small class="text-muted">• {{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="text-dark fs-5">
                                    {!! $comment->comment_content !!}
                                </div>
                            </div>
                            @auth
                                @if(Auth::id() === $comment->user_id)
                                    <form action="{{ route('comment.destroy', $comment) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-close" onclick="return confirm('Delete?')"></button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="far fa-comments fa-4x text-muted mb-3"></i>
                    <p class="fs-4 text-muted">No replies yet. Be the first!</p>
                </div>
            @endforelse

            {{-- Reply Form --}}
            @auth
                <div class="card shadow-lg border-0 mt-5">
                    <div class="card-header bg-primary text-white text-center py-4 fw-bold">
                        Reply to Topic
                    </div>
                    <div class="card-body p-5 bg-white">
                        <form action="{{ route('comment.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="topic_id" value="{{ $topic->topic_id }}">
                            <textarea name="content" id="summernote" class="form-control" required></textarea>
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    Post Reply
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <h4>Want to reply?</h4>
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5">Login to Comment</a>
                </div>
            @endauth

        </div>
    </div>
</div>
@endsection