{{-- resources/views/manage/admin/category.blade.php --}}
@extends('manage.admin.index')



@section('breadcrumb')
    <b class="breadcrumb-item">{{ config('app.name') }}</b>
    <li class="breadcrumb-item active" aria-current="page">Categories</li>
@endsection

@section('content')

<style>
@media (max-width: 768px) {
    table thead { display: none; }
    table tbody tr {
        display: block;
        margin-bottom: 12px;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 12px;
        background: #fff;
    }
    table tbody td {
        display: flex;
        justify-content: space-between;
        padding: 6px 8px;
        text-align: right;
    }
    table tbody td:before {
        content: attr(data-label);
        font-weight: bold;
        text-align: left;
        color: #555;
    }
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Categories</h1>
        <p class="mb-0 text-muted small">Manage packages categories & appearance</p>
    </div>
    <button type="button" class="btn btn-primary shadow-sm btn-lg rounded-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
        <i class="fas fa-plus me-2"></i> Add New Category
    </button>
</div>

{{-- FLASH MESSAGES --}}
@foreach(['manageCategoryAdded' => 'success', 'manageCategoryUpdated' => 'success', 'manageCategoryRemoved' => 'danger'] as $msg => $type)
@if(session($msg))
<div class="alert alert-{{ $type }} alert-dismissible fade show rounded-3 shadow-sm">
    {{ session($msg) }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@endforeach

{{-- SEARCH / FILTER BAR --}}
<div class="card shadow-sm mb-3 border-0 rounded-4">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-md-4 col-12">
                <input id="searchInput" type="text" class="form-control rounded-3" placeholder="Search categories...">
            </div>
            <div class="col-md-4 col-12">
                <select id="visibilityFilter" class="form-select rounded-3">
                    <option value="">All</option>
                    <option value="visible">Visible</option>
                    <option value="hidden">Hidden</option>
                </select>
            </div>
            <div class="col-md-4 col-12">
                <select id="sortColumn" class="form-select rounded-3">
                    <option value="">Sort By</option>
                    <option value="name">Name (A–Z)</option>
                    <option value="id">ID (Low–High)</option>
                    <option value="sort_order">Sort Order (Low–High)</option>
                </select>
            </div>
        </div>
    </div>
</div>

{{-- CATEGORIES TABLE – CLEAN & PREMIUM --}}
<div class="card shadow border-0 rounded-4 mb-4 overflow-hidden">
    <div class="card-header py-4 d-flex justify-content-between align-items-center"
         style="background: linear-gradient(90deg, #4e73df, #224abe);">
        <h6 class="m-0 fw-bold text-white mb-0">All Categories</h6>
        <span class="badge bg-white text-primary fs-5 px-4 py-2">{{ count($categorys) }} categories</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 fw-semibold">No.</th>
                        <th class="fw-semibold">Name</th>
                        <th class="fw-semibold">Image</th>
                        <th class="fw-semibold">Badge / Ribbon</th>
                        <th class="fw-semibold text-center">Visible</th>
                        <th class="text-center fw-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody id="categoryTable">
                @forelse($categorys as $cat)
                    <tr data-visible="{{ $cat->is_visible ? 'visible' : 'hidden' }}">
                         {{--  Beautiful 1, 2, 3... instead of DB ID --}}
                        <td data-label="No." class="ps-4">
                            <strong class="text-primary fs-5">#{{ $loop->iteration }}</strong>
                        </td>

                        <td data-label="Name">
                            <div class="fw-bold text-dark">{{ $cat->category_name }}</div>
                            @if($cat->description)
                                <small class="text-muted d-block">{{ Str::limit($cat->description, 60) }}</small>
                            @endif
                        </td>

                        <td data-label="Image">
                            @if($cat->category_image)
                                <img src="{{ asset('uploads/packages/category/' . $cat->category_image) }}"
                                     width="64" height="64"
                                     class="rounded-3 shadow-sm object-fit-cover border">
                            @else
                                <div class="bg-light rounded-3 border d-flex align-items-center justify-content-center" style="width:64px;height:64px;">
                                    <i class="fas fa-folder text-muted fs-3"></i>
                                </div>
                            @endif
                        </td>

                        <td data-label="Badges">
                            @if($cat->badge_text)
                                <span class="badge bg-{{ str_replace('is-', '', $cat->badge_color ?? 'danger') }} px-3 py-2 me-2">
                                    {{ $cat->badge_text }}
                                </span>
                            @endif
                            @if($cat->ribbon_text)
                                <span class="badge bg-info px-3 py-2">
                                    {{ $cat->ribbon_text }}
                                </span>
                            @endif
                            @if(!$cat->badge_text && !$cat->ribbon_text)
                                <span class="text-muted small">—</span>
                            @endif
                        </td>

                        <td data-label="Visible" class="text-center">
                            @if($cat->is_visible)
                                <i class="fas fa-eye text-success fa-xl" title="Visible to players"></i>
                            @else
                                <i class="fas fa-eye-slash text-danger fa-xl" title="Hidden"></i>
                            @endif
                        </td>

                        <td data-label="Actions" class="text-center">
                            @if($cat->category_id != 1)
                                <button type="button"
                                        class="btn btn-info btn-sm shadow-sm me-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editCategoryModal-{{ $cat->category_id }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form action="{{ route('category.destroy', $cat->category_id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete {{ addslashes($cat->category_name) }} forever?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm shadow-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-warning text-dark px-3 py-2">Reserved</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-muted">
                            <i class="fas fa-folder-open fa-5x mb-4 opacity-25"></i>
                            <h5>No categories yet</h5>
                            <p class="text-muted">Create your first category to organize packages!</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


{{-- ADD CATEGORY MODAL --}}
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title fw-bold">Add New Category</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                            <input type="text" name="category_name" class="form-control form-control-lg rounded-3" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Description</label>
                            <input type="text" name="description" class="form-control rounded-3">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Image (512x512 recommended)</label>
                            <input type="file" name="category_image" accept="image/*" class="form-control rounded-3">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Top Badge (e.g. SALE!)</label>
                            <input type="text" name="badge_text" class="form-control rounded-3" placeholder="SALE!">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Badge Color</label>
                            <select name="badge_color" class="form-select rounded-3">
                                <option value="is-danger">Red</option>
                                <option value="is-success">Green</option>
                                <option value="is-warning">Yellow</option>
                                <option value="is-info">Blue</option>
                                <option value="is-primary">Purple</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Ribbon (e.g. NEW)</label>
                            <input type="text" name="ribbon_text" class="form-control rounded-3" placeholder="NEW">
                        </div>

                        <div class="col-md-4">
                            <div class="form-check mt-4">
                                <input type="checkbox" name="is_featured" class="form-check-input" id="featAdd">
                                <label class="form-check-label" for="featAdd">Featured</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-check mt-4">
                                <input type="checkbox" name="is_visible" class="form-check-input" id="visAdd" checked>
                                <label class="form-check-label" for="visAdd">Visible</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control rounded-3" value="0">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Background Color (hex)</label>
                            <input type="text" name="background_color" class="form-control rounded-3" placeholder="#ff6b6b">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Custom CSS</label>
                            <textarea name="custom_css" rows="4" class="form-control rounded-3"></textarea>
                        </div>

                    </div>

                    <div class="text-center mt-5">
                        <button type="submit" class="btn btn-success btn-lg px-6 rounded-3 shadow-sm">
                            CREATE CATEGORY
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


{{-- EDIT MODALS (AJAX LOADED - VISUAL POLISH ONLY) --}}
@foreach($categorys as $cat)
<div class="modal fade" id="editCategoryModal-{{ $cat->category_id }}" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 shadow-lg">

            <div class="modal-header bg-info text-white rounded-top-4">
                <h5 class="modal-title fw-bold">Edit: {{ $cat->category_name }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4" id="editForm-{{ $cat->category_id }}">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endforeach



 {{--  ================================
       SEARCH / FILTER / SORT JS
     ================================ --}}
<script>
document.addEventListener("DOMContentLoaded", () => {

    const searchInput = document.getElementById("searchInput");
    const visibilityFilter = document.getElementById("visibilityFilter");
    const sortSelect = document.getElementById("sortColumn");
    const tbody = document.getElementById("categoryTable");

    function getRows() {
        return [...tbody.querySelectorAll("tr")];
    }

    function filterTable() {
        let text = searchInput.value.toLowerCase();
        let visibility = visibilityFilter.value;

        getRows().forEach(row => {
            let name = row.querySelector("td[data-label='Name']").innerText.toLowerCase();
            let rowVis = row.getAttribute("data-visible");

            let visible = true;

            if (text && !name.includes(text)) visible = false;
            if (visibility && rowVis !== visibility) visible = false;

            row.style.display = visible ? "" : "none";
        });
    }

    function sortTable() {
        const type = sortSelect.value;
        let rows = getRows();

        let sorted = [...rows];

        if (type === "name") {
            sorted.sort((a, b) =>
                a.querySelector("td[data-label='Name']").innerText.localeCompare(
                b.querySelector("td[data-label='Name']").innerText));
        }

        if (type === "id") {
            sorted.sort((a, b) =>
                parseInt(a.querySelector("td[data-label='ID']").innerText) -
                parseInt(b.querySelector("td[data-label='ID']").innerText));
        }

        if (type === "sort_order") {
            sorted.sort((a, b) =>
                parseInt(a.getAttribute("data-sort") ?? 0) -
                parseInt(b.getAttribute("data-sort") ?? 0)
            );
        }

        sorted.forEach(r => tbody.appendChild(r));
    }

    searchInput.addEventListener("keyup", filterTable);
    visibilityFilter.addEventListener("change", filterTable);
    sortSelect.addEventListener("change", sortTable);

});
</script>
{{-- JAVASCRIPT --}}
<script>
document.querySelectorAll('[data-bs-target^="#editCategoryModal-"]').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.getAttribute('data-bs-target').split('-').pop();
        const container = document.getElementById('editForm-' + id);

        container.innerHTML = `<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>`;

      fetch(`/admin/dashboard/packages/category/${id}/edit`)

            .then(r => r.text())
            .then(html => {
                container.innerHTML = html;
            })
            .catch(() => {
                container.innerHTML = '<div class="alert alert-danger">Failed to load form.</div>';
            });
    });
});
</script>
@endsection
