<form action="{{ route('category.update', $category) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="row g-4">
        <div class="col-md-6">
            <label class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
            <input class="form-control form-control-lg @error('category_name') is-invalid @enderror"
                   type="text" name="category_name"
                   value="{{ old('category_name', $category->category_name) }}" required>
            @error('category_name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold">Description</label>
            <input class="form-control form-control-lg @error('description') is-invalid @enderror"
                   type="text" name="description"
                   value="{{ old('description', $category->description) }}">
            @error('description')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold">Current Image</label>
            @if($category->category_image)
                <div class="mb-3">
                    <img src="{{ asset('uploads/packages/category/' . $category->category_image) }}"
                         width="120" class="img-thumbnail rounded">
                </div>
            @endif
            <input type="file" name="category_image" accept="image/*" class="form-control @error('category_image') is-invalid @enderror">
            @error('category_image')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold">Top Badge (SALE!)</label>
            <input class="form-control form-control-lg @error('badge_text') is-invalid @enderror"
                   type="text" name="badge_text"
                   value="{{ old('badge_text', $category->badge_text) }}" placeholder="SALE!">
            @error('badge_text')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold">Badge Color</label>
            <div class="d-flex flex-wrap gap-4 mt-2">
                <label class="form-check">
                    <input class="form-check-input" type="radio" name="badge_color" value="is-danger"
                           {{ old('badge_color', $category->badge_color) == 'is-danger' ? 'checked' : '' }}>
                    <span class="fw-bold text-danger">Red</span>
                </label>
                <label class="form-check">
                    <input class="form-check-input" type="radio" name="badge_color" value="is-success"
                           {{ old('badge_color', $category->badge_color) == 'is-success' ? 'checked' : '' }}>
                    <span class="fw-bold text-success">Green</span>
                </label>
                <label class="form-check">
                    <input class="form-check-input" type="radio" name="badge_color" value="is-warning"
                           {{ old('badge_color', $category->badge_color) == 'is-warning' ? 'checked' : '' }}>
                    <span class="fw-bold text-warning">Yellow</span>
                </label>
                <label class="form-check">
                    <input class="form-check-input" type="radio" name="badge_color" value="is-info"
                           {{ old('badge_color', $category->badge_color) == 'is-info' ? 'checked' : '' }}>
                    <span class="fw-bold text-info">Blue</span>
                </label>
                <label class="form-check">
                    <input class="form-check-input" type="radio" name="badge_color" value="is-primary"
                           {{ old('badge_color', $category->badge_color) == 'is-primary' ? 'checked' : '' }}>
                    <span class="fw-bold text-primary">Purple</span>
                </label>
            </div>
            @error('badge_color')
                <div class="text-danger small d-block mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold">Ribbon (NEW)</label>
            <input class="form-control form-control-lg @error('ribbon_text') is-invalid @enderror"
                   type="text" name="ribbon_text"
                   value="{{ old('ribbon_text', $category->ribbon_text) }}" placeholder="NEW">
            @error('ribbon_text')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <div class="form-check form-switch mt-4">
                <input class="form-check-input" type="checkbox" name="is_featured" id="featured"
                       {{ old('is_featured', $category->is_featured) ? 'checked' : '' }}>
                <label class="form-check-label fw-bold" for="featured">Featured Category</label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-check form-switch mt-4">
                <input class="form-check-input" type="checkbox" name="is_visible" id="visible"
                       {{ old('is_visible', $category->is_visible ?? 1) ? 'checked' : '' }}>
                <label class="form-check-label fw-bold" for="visible">Visible in Shop</label>
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold">Sort Order</label>
            <input class="form-control form-control-lg @error('sort_order') is-invalid @enderror"
                   type="number" name="sort_order"
                   value="{{ old('sort_order', $category->sort_order ?? 0) }}">
            @error('sort_order')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold">Background Color</label>
            <input class="form-control form-control-lg @error('background_color') is-invalid @enderror"
                   type="text" name="background_color"
                   value="{{ old('background_color', $category->background_color) }}" placeholder="#ff6b6b">
            @error('background_color')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <label class="form-label fw-bold">Custom CSS</label>
            <textarea class="form-control font-monospace @error('custom_css') is-invalid @enderror"
                      name="custom_css" rows="4">{{ old('custom_css', $category->custom_css) }}</textarea>
            @error('custom_css')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="text-center mt-5">
        <button type="submit" class="btn btn-success btn-lg px-6 shadow-sm">
            SAVE CHANGES
        </button>
    </div>
</form>