

@extends('layouts.app')

@section('title', 'Forum')

@section('content')

{{-- Hero - same as all other forum pages --}}
<div class="hero-section text-white text-center position-relative">
    <div class="container position-relative">
        <h1 class="display-3 fw-bold text-uppercase mb-3">FORUMS</h1>
        <h5 class="fw-light fs-3 opacity-90">{{ $settings->website_name }} Community</h5>
    </div>
</div>

<div class="container my-5">

    {{-- Header + Buttons --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-4">
        <div>
            <h3 class="fw-bold text-white mb-1">Forum Topics</h3>
            <p class="text-light opacity-80 fs-5 mb-0">Total {{ $topics->count() }} topics</p>
        </div>
        <div class="d-flex gap-3 flex-wrap">
            <a href="{{ route('topic.create') }}" class="btn btn-outline-light px-5 py-3 fw-bold">
                Add New Topic
            </a>
            <a href="{{ route('topicmanager.index') }}" class="btn btn-dark px-5 py-3 fw-bold">
                My Topics
            </a>
        </div>
    </div>

    <div class="row g-5">
        {{-- MAIN CONTENT --}}
        <div class="col-lg-10">
            {{-- Main White Card - same style as topic.show --}}
            <div class="content-card shadow-lg mb-5">
                <div class="card-header py-4 text-white text-center fw-bold" style="background: var(--primary); border-radius: 20px 20px 0 0;">
                    <h4 class="mb-0">Browse Topics</h4>
                </div>

                <div class="card-body p-0 bg-white">
                    {{-- Tabs --}}
                    <ul class="nav nav-tabs border-0">
                        <li class="nav-item">
                            <button class="nav-link active fw-bold text-primary" data-bs-toggle="tab" data-bs-target="#popular">Popular</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#latest">Newest</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#all">All Posts</button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        {{-- Popular --}}
                        <div class="tab-pane fade show active p-5" id="popular">
                            <h5 class="fw-bold text-primary mb-4">Top 10 Most Viewed Topics</h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <tbody>
                                    @foreach($mostviews as $key => $topic)
                                        <tr class="border-bottom">
                                            <td class="py-4">
                                                <div>
                                                    <a href="{{ route('topic.show', $topic->topic_id) }}"
                                                       class="text-decoration-none text-dark fw-bold fs-5">
                                                        {{ $topic->topic_title }}
                                                        @if($key < 3)
                                                            <span class="badge bg-danger text-white ms-2">#{{ $key + 1 }}</span>
                                                        @endif
                                                    </a>
                                                    <div class="small text-muted mt-2">
                                                       By {{ optional($topic->author)->name ?? 'Unknown' }}

                                                        • {{ $topic->topic_views }} views
                                                        • {{ $topic->comments->count() }} replies
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Latest --}}
                        <div class="tab-pane fade p-5" id="latest">
                            <h5 class="fw-bold text-primary mb-4">Latest Topics</h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <tbody>
                                    @foreach($lastest as $key => $topic)
                                        <tr class="border-bottom">
                                            <td class="py-4">
                                                <div>
                                                    <a href="{{ route('topic.show', $topic->topic_id) }}"
                                                       class="text-decoration-none text-dark fw-bold fs-5">
                                                        {{ $topic->topic_title }}
                                                        @if($key == 0)
                                                            <span class="badge bg-success text-white ms-2">NEW</span>
                                                        @endif
                                                    </a>
                                                    <div class="small text-muted mt-2">
                                                        By {{ optional($topic->author)->name ?? 'Unknown' }}
                                                        • {{ $topic->topic_views }} views
                                                        • {{ $topic->comments->count() }} replies
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- All Posts --}}
                        <div class="tab-pane fade p-5" id="all">
                            <h5 class="fw-bold text-primary mb-4">All Topics</h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <tbody>
                                    @foreach($topics as $topic)
                                        <tr class="border-bottom">
                                            <td class="py-4">
                                                <div>
                                                    <a href="{{ route('topic.show', $topic->topic_id) }}"
                                                       class="text-decoration-none text-dark fw-bold fs-5">
                                                        {{ $topic->topic_title }}
                                                    </a>
                                                    <div class="small text-muted mt-2">
                                                        By {{ optional($topic->author)->name ?? 'Unknown' }}
                                                        • {{ $topic->topic_views }} views
                                                        • {{ $topic->comments->count() }} replies
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SIDEBAR - clean white card --}}
        <div class="col-lg-2">
            <div class="card shadow-lg border-0 sticky-top content-card" style="top:100px;">
                <div class="card-header text-white fw-bold text-center py-4" style="background: var(--primary); border-radius: 20px 20px 0 0;">
                    Categories
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