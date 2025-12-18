{{-- resources/views/store/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Store')  


@section('content')

{{--  HERO --}}
<div class="hero-section text-white text-center position-relative">
    <div class="container position-relative">
        <h1 class="display-3 fw-bold text-uppercase mb-3">{{ $settings->website_name }}</h1>
        <h5 class="fw-light fs-3 opacity-90 mb-5">{{ $settings->homepage_highlight }}</h5>

        <a href="#store" class="btn text-white fw-bold px-5 py-3 rounded-pill shadow-lg"
           style="background: var(--primary); font-size: 1.15rem;">
            Start Shopping
        </a>
    </div>
</div>

{{--  STORE CONTENT --}}
<section class="py-5" id="store">
    <div class="container">
        <div class="row g-5">

            {{--  LEFT: CATEGORY SIDEBAR --}}
            <div class="col-lg-3 col-md-4">
                <div class="category-sidebar">
                    <h4 class="mb-4 text-white fw-bold text-center text-lg-start">
                        Categories
                    </h4>

                    @foreach($categorys as $category)
                        @if($category->packages->count() > 0)
                            <div class="category-package {{ $loop->first ? 'active' : '' }}"
                                 data-category="{{ $category->category_id }}">

                                {{ $category->category_name }}

                                <span class="badge bg-secondary float-end">
                                    {{ $category->packages->count() }}
                                </span>

                                @if($category->badge_text)
                                    <span class="badge bg-danger ms-2">
                                        {{ $category->badge_text }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{--  RIGHT: PACKAGE GRID --}}
            <div class="col-lg-9 col-md-8">
                <div id="package-container">

                    {{--  ALL PACKAGES --}}
                    <div class="package-grid row g-4" id="grid-all">
                        @foreach($packages as $package)
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="position-relative h-100">
                                    <div class="cyber-card">
                                        <div class="cyber-glow"></div>
                                        @include('store.partials.item-card')
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{--  CATEGORY GRIDS --}}
                    @foreach($categorys as $category)
                        @if($category->packages->count() > 0)
                            <div class="package-grid row g-4 d-none"
                                 id="grid-{{ $category->category_id }}">

                                @foreach($category->packages as $package)
                                    <div class="col-12 col-sm-6 col-lg-4">
                                        <div class="position-relative h-100">
                                            <div class="cyber-card">
                                                <div class="cyber-glow"></div>
                                                @include('store.partials.item-card')
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        @endif
                    @endforeach

                </div>
            </div>

        </div>
    </div>
</section>

@endsection


{{--  PAGE SCRIPTS --}}
@push('scripts')
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const categories = document.querySelectorAll('.category-package');
    const grids = document.querySelectorAll('.package-grid');

    // HIDE ALL GRIDS FIRST
    grids.forEach(grid => grid.classList.add('d-none'));

    //AUTO-SELECT FIRST CATEGORY IF EXISTS
    const firstCategory = categories[0];
    if (firstCategory) {
        firstCategory.classList.add('active');
        const firstTarget = firstCategory.getAttribute('data-category');
        const firstGrid = document.getElementById('grid-' + firstTarget);
        if (firstGrid) {
            firstGrid.classList.remove('d-none');
        }
    }

    categories.forEach(cat => {
        cat.addEventListener('click', function () {
            const target = this.getAttribute('data-category');

            categories.forEach(c => c.classList.remove('active'));
            this.classList.add('active');

            grids.forEach(grid => grid.classList.add('d-none'));

            const selectedGrid = document.getElementById('grid-' + target);
            if (selectedGrid) {
                selectedGrid.classList.remove('d-none');
            }
        });
    });
});
</script>
@endpush

@endpush
