{{-- resources/views/manage/admin/package.blade.php --}}
@extends('manage.admin.index')

@section('title', 'Dashboard')
@section('breadcrumb')
    <b class="breadcrumb-item">{{ config('app.name') }}</b>
    <li class="breadcrumb-item active" aria-current="page">Packages</li>
@endsection

@section('content')

<style>
/* ===========================
   MOBILE RESPONSIVE TABLE
=========================== */
@media (max-width: 768px) {
    table thead {
        display: none;
    }

    table tbody tr {
        display: block;
        margin-bottom: 16px;
        padding: 16px;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 10px 22px rgba(0,0,0,0.08);
        border: none;
        transition: 0.2s ease;
    }

    table tbody td {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
    }

    table tbody td:before {
        content: attr(data-label);
        font-weight: 600;
        color: #555;
    }
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800">Packages</h1>
        <p class="mb-0 text-muted small">Manage all player-purchasable packages</p>
    </div>

    <button type="button" class="btn btn-primary shadow btn-lg" data-bs-toggle="modal" data-bs-target="#addItemModal">
        <i class="fas fa-plus me-2"></i> Add New Package
    </button>
</div>


 {{--   SEARCH + FILTER + SORT BAR  --}}
<div class="card shadow-sm mb-3 border-0 rounded-4">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-md-4 col-12">
                <input id="searchInput" type="text" class="form-control rounded-3" placeholder="Search packages...">
            </div>

            <div class="col-md-4 col-12">
                <select id="categoryFilter" class="form-select rounded-3">
                    <option value="">All Categories</option>
                    @foreach($categorys as $cat)
                        <option value="{{ strtolower($cat->category_name) }}"> {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 col-12">
                <select id="sortColumn" class="form-select rounded-3">
                    <option value="">Sort By</option>
                    <option value="name">Name (A–Z)</option>
                    <option value="price">Price (Low–High)</option>
                    <option value="sold">Sold (High–Low)</option>
                </select>
            </div>
        </div>
    </div>
</div>


 {{--  PACKAGES TABLE  --}}
<div class="card shadow border-0 mb-4 rounded-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center" style="background: linear-gradient(90deg, #4e73df, #224abe); border-radius: 16px 16px 0 0;">
        <h6 class="m-0 fw-bold text-white">All Packages</h6>
        <span class="badge bg-light text-dark fs-6">{{ count($packages) }} packages</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No.</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Sold</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="itemsTable">
                @forelse($packages as $package)
                    <tr data-category="{{ strtolower($package->category->category_name ?? '') }}">
                        <td data-label="No." class="ps-4">
                            <strong class="text-primary">#{{ $loop->iteration }}</strong>
                        </td>
                        <td data-label="Image">
                            @if($package->package_image_path)
                                <img src="{{ asset('uploads/packages/cover/' . $package->package_image_path) }}" 
                                     width="50" height="50" class="rounded-circle border shadow-sm object-fit-cover">
                            @else
                                <div class="bg-light border rounded-circle" style="width:50px;height:50px;"></div>
                            @endif
                        </td>
                        <td data-label="Name">
                            <div class="fw-bold">{{ $package->package_name }}</div>
                            @if($package->package_desc)
                                <small class="text-muted">{{ Str::limit($package->package_desc, 50) }}</small>
                            @endif
                        </td>
                        <td data-label="Price">
                           <div class="text-success fw-bold">
    {{ currency_symbol() }}{{ number_format(currency_convert($package->package_price)) }}
</div>

                            @if($package->package_discount_price)
                             <small class="text-danger fw-bold">
    → {{ currency_symbol() }}{{ number_format(currency_convert($package->package_discount_price), 2) }}
</small>

                            @endif
                        </td>
                        <td data-label="Sold">
                            <span class="badge bg-info text-dark fs-6 px-3">{{ $package->package_sold ?? 0 }}</span>
                        </td>
                        <td data-label="Actions" class="text-center">
                            <button type="button" class="btn btn-sm btn-info shadow-sm me-2" 
                                    data-bs-toggle="modal" data-bs-target="#editItemModal-{{ $package->package_id }}">
                                Edit
                            </button>
                            <form action="{{ route('packages.doDelete') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="id" value="{{ $package->package_id }}"> 
                                <button type="submit" class="btn btn-sm btn-danger shadow-sm"
                                        onclick="return confirm('Delete {{ addslashes($package->package_name) }} forever?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-box-open fa-4x mb-3"></i>
                            <div class="h5">No packages yet</div>
                            <small>Click "Add New Package" to create your first one!</small>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
 {{-- ADD ITEM MODAL --}}

{{-- ADD ITEM MODAL --}}
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add New Package</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('package.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4 text-center">
                            <label class="form-label fw-bold">Package Image *</label>
                            <img id="addImagePreview" src="https://via.placeholder.com/150" class="img-thumbnail mb-3" style="display:none; max-height: 180px; width:100%; object-fit:cover;">
                            <input type="file" name="cover" accept="image/*" class="form-control" required onchange="previewAddImage(event)">
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Package Name *</label>
                                <input type="text" name="package_name" class="form-control form-control-lg text-center fw-bold" required maxlength="32" placeholder="VIP+">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description / Tagline</label>
                                <input type="text" name="package_desc" class="form-control" maxlength="100" placeholder="Next level perks • Exclusive access">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-md-6">
                            <label class="form-label">Original Price (points) *</label>
                            <input type="number" name="package_price" class="form-control" required min="1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sale Price (optional)</label>
                            <input type="number" name="package_discount_price" class="form-control text-success fw-bold" min="1">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Features (one per line)</label>
                        <textarea name="package_features" rows="6" class="form-control" placeholder="/fly command&#10;/kit vip&#10;x2 vote rewards&#10;Custom prefix"></textarea>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-md-4">
                            <label class="form-label">Top Badge (e.g. SALE!)</label>
                            <input type="text" name="badge_text" class="form-control" maxlength="20" placeholder="SALE!">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Badge Color</label>
                            <select name="badge_color" class="form-select">
                                <option value="is-danger">Red</option>
                                <option value="is-success">Green</option>
                                <option value="is-warning">Yellow</option>
                                <option value="is-info">Blue</option>
                                <option value="is-primary">Purple</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Ribbon (e.g. NEW)</label>
                            <input type="text" name="ribbon_text" class="form-control" maxlength="10" placeholder="NEW">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="featuredAdd">
                            <label class="form-check-label" for="featuredAdd">Mark as Featured Package</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Command to Run (use %player) *</label>
                        <textarea name="package_command" rows="4" class="form-control" required placeholder="lp user %player permission set vip.plus true"></textarea>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category *</label>
                        <select name="category" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            @foreach($categorys as $cat)
                                <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="text-center mt-5">
                        <button type="submit" class="btn btn-success btn-lg px-6">CREATE PACKAGE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{--  EDIT MODALS --}}
@foreach($packages as $package)
<div class="modal fade" id="editItemModal-{{ $package->package_id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-4 shadow-lg border-0">
            <div class="modal-header bg-info text-white rounded-top-4">
                <h5 class="modal-title fw-bold">Edit: {{ $package->package_name }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <form action="{{ route('packages.doUpdate') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $package->package_id }}">

                    <div class="row g-4">
                        <div class="col-md-4 text-center">
                            <label class="form-label fw-bold mb-2">Current Image</label>

                            <img id="editImagePreview-{{ $package->package_id }}" src="{{ $package->package_image_path ? asset('uploads/packages/cover/' . $package->package_image_path) : 'https://via.placeholder.com/150' }}" class="img-thumbnail mb-3 shadow-sm rounded-3" style="max-height: 180px; width:100%; object-fit:cover;">

                            <input type="file" name="cover" accept="image/*" class="form-control rounded-3" onchange="previewEditImage(event, {{ $package->package_id }})">
                        </div>

                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Package Name *</label>
                                <input type="text" name="package_name" class="form-control form-control-lg text-center fw-bold rounded-3" value="{{ $package->package_name }}" required maxlength="32">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Description / Tagline</label>
                                <input type="text" name="package_desc" class="form-control rounded-3" value="{{ $package->package_desc }}" maxlength="100">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3 mt-2">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Original Price *</label>
                            <input type="number" name="package_price" class="form-control rounded-3" value="{{ $package->package_price }}" required min="1">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Sale Price</label>
                            <input type="number" name="package_discount_price" class="form-control rounded-3 text-success fw-bold" value="{{ $package->package_discount_price }}" min="1">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Features</label>
                        <textarea name="package_features" rows="6" class="form-control rounded-3">{{ $package->package_features }}</textarea>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Top Badge</label>
                            <input type="text" name="badge_text" class="form-control rounded-3" value="{{ $package->badge_text }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Badge Color</label>
                            <select name="badge_color" class="form-select rounded-3">
                                <option value="is-danger" {{ $package->badge_color == 'is-danger' ? 'selected' : '' }}>Red</option>
                                <option value="is-success" {{ $package->badge_color == 'is-success' ? 'selected' : '' }}>Green</option>
                                <option value="is-warning" {{ $package->badge_color == 'is-warning' ? 'selected' : '' }}>Yellow</option>
                                <option value="is-info" {{ $package->badge_color == 'is-info' ? 'selected' : '' }}>Blue</option>
                                <option value="is-primary" {{ $package->badge_color == 'is-primary' ? 'selected' : '' }}>Purple</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Ribbon</label>
                            <input type="text" name="ribbon_text" class="form-control rounded-3" value="{{ $package->ribbon_text }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="featuredEdit{{ $package->package_id }}" {{ $package->is_featured ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="featuredEdit{{ $package->package_id }}">
                                Mark as Featured Package
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Command *</label>
                        <textarea name="package_command" rows="4" class="form-control rounded-3" required>{{ $package->package_command }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category *</label>
                        <select name="category" class="form-select rounded-3" required>
                            <option value="">-- Select Category --</option>
                            @foreach($categorys as $cat)
                                <option value="{{ $cat->category_id }}" {{ $package->category_id == $cat->category_id ? 'selected' : '' }}> {{ $cat->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="text-center mt-5">
                        <button type="submit" class="btn btn-success btn-lg px-5 shadow">
                            SAVE CHANGES
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endforeach



 {{--  SEARCH / FILTER / SORT JS --}}
<script> 
document.addEventListener("DOMContentLoaded", () => {

    const searchInput = document.getElementById("searchInput");
    const categoryFilter = document.getElementById("categoryFilter");
    const sortSelect = document.getElementById("sortColumn");
    const tbody = document.getElementById("itemsTable");

    function getRows() {
        return [...tbody.querySelectorAll("tr")];
    }

    function filterTable() {
        const text = searchInput.value.toLowerCase();
        const category = categoryFilter.value.toLowerCase();

        getRows().forEach(row => {
            const name = row.querySelector("td[data-label='Name']").innerText.toLowerCase();
            const rowCategory = row.getAttribute("data-category");

            let visible = true;
            if (text && !name.includes(text)) visible = false;
            if (category && rowCategory !== category) visible = false;

            row.style.display = visible ? "" : "none";
        });
    }

    function sortTable() {
        const rows = getRows();
        const sortBy = sortSelect.value;

        let sorted = [...rows];

        if (sortBy === "name") {
            sorted.sort((a, b) =>
                a.querySelector("td[data-label='Name']").innerText.localeCompare(
                b.querySelector("td[data-label='Name']").innerText)
            );
        }

        if (sortBy === "price") {
            sorted.sort((a, b) =>
                parseInt(a.querySelector("td[data-label='Price']").innerText) -
                parseInt(b.querySelector("td[data-label='Price']").innerText)
            );
        }

        if (sortBy === "sold") {
            sorted.sort((a, b) =>
                parseInt(b.querySelector("td[data-label='Sold']").innerText) -
                parseInt(a.querySelector("td[data-label='Sold']").innerText)
            );
        }

        sorted.forEach(row => tbody.appendChild(row));
    }

    searchInput.addEventListener("keyup", filterTable);
    categoryFilter.addEventListener("change", filterTable);
    sortSelect.addEventListener("change", sortTable);
});
</script>



{{-- IMAGE PREVIEW JS (UNCHANGED) --}}
<script>
function previewAddImage(e) {
    const preview = document.getElementById('addImagePreview');
    if (e.target.files[0]) {
        preview.src = URL.createObjectURL(e.target.files[0]);
        preview.style.display = 'block';
    }
}
function previewEditImage(e, id) {
    const preview = document.getElementById('editImagePreview-' + id);
    if (e.target.files[0]) {
        preview.src = URL.createObjectURL(e.target.files[0]);
    }
}
</script>

@endsection
