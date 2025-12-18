{{-- resources/views/manage/admin/alert.blade.php --}}
@extends('manage.admin.index')



@section('breadcrumb')
    <b class="breadcrumb-item">{{ config('app.name') }}</b>
    <li class="breadcrumb-item active" aria-current="page">Announcement</li>
@endsection

@section('content')

<style>
/* ===========================
   MOBILE RESPONSIVE TABLE
   =========================== */
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
    }
    table tbody td:before {
        content: attr(data-label);
        font-weight: bold;
        color: #444;
    }
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Announcements & News</h1>
        <p class="mb-0 text-muted small">Manage server-wide announcements and store news</p>
    </div>
    <button type="button" class="btn btn-primary shadow-sm btn-lg" data-bs-toggle="modal" data-bs-target="#createAlertModal">
        Create Announcement
    </button>
</div>

{{-- FLASH MESSAGES --}}
@if(session('manageAlertAdded'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('manageAlertAdded') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('manageAlertUpdated'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('manageAlertUpdated') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('manageAlertRemoved'))
<div class="alert alert-danger alert-dismissible fade show">
    {{ session('manageAlertRemoved') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('alertError'))
<div class="alert alert-warning alert-dismissible fade show">
    {{ session('alertError') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif


 {{--  ================================
     SEARCH + FILTER + SORT BAR
     ================================ --}}
<div class="card shadow mb-3 border-0">
    <div class="card-body">
        <div class="row g-2">

            <div class="col-md-4 col-12">
                <input id="searchInput" type="text" class="form-control" placeholder="Search announcements...">
            </div>

            <div class="col-md-4 col-12">
                <select id="filterStore" class="form-select">
                    <option value="">Show on Store (All)</option>
                    <option value="1">Shown</option>
                    <option value="0">Hidden</option>
                </select>
            </div>

            <div class="col-md-4 col-12">
                <select id="sortColumn" class="form-select">
                    <option value="">Sort By</option>
                    <option value="id">ID (Low–High)</option>
                    <option value="title">Title (A–Z)</option>
                    <option value="views">Views (High–Low)</option>
                </select>
            </div>

        </div>
    </div>
</div>


{{-- ANNOUNCEMENTS TABLE --}}
<div class="card shadow border-0 mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center"
         style="background: linear-gradient(90deg, #4e73df, #224abe);">
        <h6 class="m-0 font-weight-bold text-white mb-0">All Announcements</h6>
        <span class="badge bg-light text-dark fs-6">{{ count($alerts) }} items</span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Title</th>
                    <th class="text-center">Show on Store</th>
                    <th class="text-center">Views</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>

                <tbody id="alertTable">

                @forelse($alerts as $n)
                <tr data-store="{{ $n->alert_show_on_store ? '1' : '0' }}" data-views="{{ $n->alert_views }}" data-title="{{ strtolower($n->alert_title) }}">
                    
                    <td data-label="ID" class="ps-4"><strong>#{{ $n->alert_id }}</strong></td>

                    <td data-label="Title">
                        <div class="fw-bold">{{ $n->alert_title }}</div>
                        @if($n->alert_tag)
                            <span class="badge bg-secondary small">{{ $n->alert_tag }}</span>
                        @endif
                    </td>

                    <td data-label="Store" class="text-center">
                        @if($n->alert_show_on_store)
                            <i class="fas fa-check-circle text-success fa-lg"></i>
                        @else
                            <i class="fas fa-times-circle text-danger fa-lg"></i>
                        @endif
                    </td>

                    <td data-label="Views" class="text-center">
                        <span class="badge bg-info text-dark fs-6">{{ $n->alert_views }}</span>
                    </td>

                    <td data-label="Actions" class="text-center">
                        <button type="button"
                                class="btn btn-sm btn-info shadow-sm me-2"
                                data-bs-toggle="modal"
                                data-bs-target="#editAlertModal"
                                onclick="fillEditModal({{ $n->alert_id }})">
                            Edit
                        </button>

                        <form action="{{ route('alert.doDelete') }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Delete this announcement permanently?')">
                            @csrf
                            <input type="hidden" name="id" value="{{ $n->alert_id }}">
                            <button type="submit" class="btn btn-sm btn-danger shadow-sm">
                                Delete
                            </button>
                        </form>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-muted">
                        <i class="fas fa-bullhorn fa-4x mb-3 text-muted"></i>
                        <div class="h5">No announcements yet</div>
                        <small>Create your first one using the button above!</small>
                    </td>
                </tr>
                @endforelse

                </tbody>
            </table>

        </div>
    </div>
</div>



{{-- CREATE MODAL --}}
<div class="modal fade" id="createAlertModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Create New Announcement</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('alert.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Content <span class="text-danger">*</span></label>
                        <textarea name="content" rows="8" class="form-control" required placeholder="Write your announcement here..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tag (optional)</label>
                        <input type="text" name="tag" class="form-control" placeholder="e.g. UPDATE, EVENT, SALE" maxlength="20">
                    </div>
                    <div class="form-check mb-4">
                        <input type="checkbox" name="seeinstore" value="1" class="form-check-input" id="showStoreCreate">
                        <label class="form-check-label" for="showStoreCreate">
                            Show on store homepage
                        </label>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success btn-lg px-5">Create Announcement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- EDIT MODAL --}}
<div class="modal fade" id="editAlertModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Edit Announcement</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('alert.doUpdate') }}" method="POST" id="editAlertForm">
                    @csrf
                    <input type="hidden" name="id" id="edit_alert_id">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="edit_alert_title" class="form-control form-control-lg" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Content <span class="text-danger">*</span></label>
                        <textarea name="content" id="edit_alert_content" rows="8" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tag</label>
                        <input type="text" name="tag" id="edit_alert_tag" class="form-control" maxlength="20">
                    </div>
                    <div class="form-check mb-4">
                        <input type="checkbox" name="seeinstore" value="1" class="form-check-input" id="edit_alert_show">
                        <label class="form-check-label" for="edit_alert_show">
                            Show on store homepage
                        </label>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-info btn-lg px-5">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


 {{--  ================================
     EDIT MODAL JS (UNCHANGED)
 ==================================== --}}
<script>
function fillEditModal(id) {
    const row = [...document.querySelectorAll("#alertTable tr")]
                .find(r => r.querySelector("td strong").innerText.replace('#','') == id);

    const alert = @json($alerts->keyBy('alert_id'));

    document.getElementById("edit_alert_id").value = alert[id].alert_id;
    document.getElementById("edit_alert_title").value = alert[id].alert_title;
    document.getElementById("edit_alert_content").value = alert[id].alert_content;
    document.getElementById("edit_alert_tag").value = alert[id].alert_tag ?? '';
    document.getElementById("edit_alert_show").checked = !!alert[id].alert_show_on_store;
}
</script>


 {{--  ================================
     SEARCH / FILTER / SORT JS
 ==================================== --}}
<script>
document.addEventListener("DOMContentLoaded", () => {

    const searchInput = document.getElementById("searchInput");
    const filterStore = document.getElementById("filterStore");
    const sortSelect = document.getElementById("sortColumn");
    const tbody = document.getElementById("alertTable");

    const rows = [...tbody.querySelectorAll("tr")];

    function filterTable() {
        const search = searchInput.value.toLowerCase();
        const store = filterStore.value;

        rows.forEach(row => {
            const title = row.getAttribute("data-title");
            const shown = row.getAttribute("data-store");

            let show = true;

            if (search && !title.includes(search)) show = false;
            if (store && shown !== store) show = false;

            row.style.display = show ? "" : "none";
        });
    }

    function sortTable() {
        const type = sortSelect.value;

        let sorted = [...rows];

        if (type === "id") {
            sorted.sort((a, b) =>
                parseInt(a.querySelector("td strong").innerText.replace('#','')) -
                parseInt(b.querySelector("td strong").innerText.replace('#','')));
        }

        if (type === "title") {
            sorted.sort((a, b) =>
                a.getAttribute("data-title").localeCompare(
                b.getAttribute("data-title")));
        }

        if (type === "views") {
            sorted.sort((a, b) =>
                parseInt(b.getAttribute("data-views")) -
                parseInt(a.getAttribute("data-views")));
        }

        sorted.forEach(r => tbody.appendChild(r));
    }

    searchInput.addEventListener("keyup", filterTable);
    filterStore.addEventListener("change", filterTable);
    sortSelect.addEventListener("change", sortTable);

});
</script>

@endsection
