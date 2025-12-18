{{-- resources/views/manage/admin/user-manager.blade.php --}}
@extends('manage.admin.index')



@section('breadcrumb')
    <b class="breadcrumb-item">{{ config('app.name') }}</b>
    <li class="breadcrumb-item active" aria-current="page">Users</li>
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
        <h1 class="h3 mb-0 text-gray-800">User Manager</h1>
        <p class="mb-0 text-muted small">Manage all players and administrators</p>
    </div>
    <button type="button" class="btn btn-primary shadow-sm btn-lg" data-bs-toggle="modal" data-bs-target="#addUserModal">
        Add New User
    </button>
</div>

 {{--      SEARCH + FILTER + SORT BAR  --}}
<div class="card shadow mb-3 border-0">
    <div class="card-body">
        <div class="row g-2">

            <div class="col-md-4 col-12">
                <input id="searchInput" type="text" class="form-control" placeholder="Search users...">
            </div>

            <div class="col-md-4 col-12">
                <select id="roleFilter" class="form-select">
                    <option value="">All Roles</option>
                    <option value="1">Administrator</option>
                    <option value="2">Player</option>
                </select>
            </div>

            <div class="col-md-4 col-12">
                <select id="sortColumn" class="form-select">
                    <option value="">Sort By</option>
                    <option value="id">ID (Low–High)</option>
                    <option value="name">Username (A–Z)</option>
                    <option value="points">Points (High–Low)</option>
                    <option value="date">Registered (New–Old)</option>
                </select>
            </div>

        </div>
    </div>
</div>


<div class="card shadow border-0 mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center"
         style="background: linear-gradient(90deg, #4e73df, #224abe);">

        <h6 class="m-0 font-weight-bold text-white mb-0">All Users</h6>
        <span class="badge bg-light text-dark fs-6">{{ count($users) }} users</span>

    </div>

    <div class="card-body p-0">
        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th class="ps-4">ID</th>
                    <th>Role</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Points</th>
                    <th>Registered</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>

                <tbody id="usersTable">

                @forelse($users as $user)
                    <tr data-role="{{ $user->role_id }}" data-date="{{ $user->created_at->timestamp }}">
                        
                        <td data-label="ID" class="ps-4"><strong>#{{ $user->id }}</strong></td>

                        <td data-label="Role">
                            @if($user->role_id == 1)
                                <span class="badge bg-danger">Administrator</span>
                            @elseif($user->role_id == 2)
                                <span class="badge bg-success">Player</span>
                            @else
                                <span class="badge bg-secondary">Unknown</span>
                            @endif
                        </td>

                        <td data-label="Username">
                            <div class="fw-bold">{{ $user->name }}</div>
                        </td>

                        <td data-label="Email">
                            <span class="text-muted">{{ $user->email ?? '—' }}</span>
                        </td>

                        <td data-label="Points">
                            <span class="fw-bold text-success">{{ number_format($user->points_balance) }}</span>
                        </td>

                        <td data-label="Registered">
                            <small class="text-muted">{{ $user->created_at->format('d M Y') }}</small>
                        </td>

                        <td data-label="Actions" class="text-center">

                            <button type="button" class="btn btn-sm btn-info shadow-sm me-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editUserModal-{{ $user->id }}">
                                Edit
                            </button>

                            <form action="{{ route('usereditor.doDelete') }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Permanently delete {{ addslashes($user->name) }}? This cannot be undone.')">

                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">

                                <button type="submit" class="btn btn-sm btn-danger shadow-sm">
                                    Delete
                                </button>

                            </form>
                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-muted">
                            <i class="fas fa-users fa-4x mb-3 text-muted"></i>
                            <div class="h5">No users found</div>
                        </td>
                    </tr>
                @endforelse

                </tbody>

            </table>

        </div>
    </div>
</div>



{{-- ADD USER MODAL --}}
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('usereditor.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="text" name="password" class="form-control" required minlength="6">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select">
                                @foreach($rolelist as $role)
                                    <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Starting Points</label>
                            <input type="number" name="points" class="form-control" value="0" min="0">
                        </div>
                    </div>
                    <div class="text-center mt-5">
                        <button type="submit" class="btn btn-success btn-lg px-5">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- EDIT USER MODALS (ONE PER USER) --}}
@foreach($users as $user)
<div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Edit User: {{ $user->name }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('usereditor.doUpdate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select">
                                @foreach($rolelist as $role)
                                    <option value="{{ $role->role_id }}" {{ $user->role_id == $role->role_id ? 'selected' : '' }}>
                                        {{ $role->role_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                       
                    </div>

                    <div class="text-center mt-5">
                        <button type="submit" class="btn btn-success btn-lg px-5">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach



 {{--       SEARCH / FILTER / SORT JS   --}}
<script>
document.addEventListener("DOMContentLoaded", () => {

    const searchInput = document.getElementById("searchInput");
    const roleFilter = document.getElementById("roleFilter");
    const sortSelect = document.getElementById("sortColumn");
    const tbody = document.getElementById("usersTable");

    function getRows() {
        return [...tbody.querySelectorAll("tr")];
    }

    function filterTable() {
        let text = searchInput.value.toLowerCase();
        let role = roleFilter.value;

        getRows().forEach(row => {
            const username = row.querySelector("td[data-label='Username']").innerText.toLowerCase();
            const rowRole = row.getAttribute("data-role");

            let show = true;

            if (text && !username.includes(text)) show = false;
            if (role && rowRole !== role) show = false;

            row.style.display = show ? "" : "none";
        });
    }

    function sortTable() {
        const rows = getRows();
        const type = sortSelect.value;

        let sorted = [...rows];

        if (type === "id") {
            sorted.sort((a, b) =>
                parseInt(a.querySelector("td[data-label='ID']").innerText.replace('#','')) -
                parseInt(b.querySelector("td[data-label='ID']").innerText.replace('#','')));
        }

        if (type === "name") {
            sorted.sort((a, b) => 
                a.querySelector("td[data-label='Username']").innerText.localeCompare(
                b.querySelector("td[data-label='Username']").innerText));
        }

        if (type === "points") {
            sorted.sort((a, b) =>
                parseInt(b.querySelector("td[data-label='Points']").innerText.replace(/,/g,'')) -
                parseInt(a.querySelector("td[data-label='Points']").innerText.replace(/,/g,'')));
        }

        if (type === "date") {
            sorted.sort((a, b) =>
                parseInt(b.getAttribute("data-date")) -
                parseInt(a.getAttribute("data-date")));
        }

        sorted.forEach(r => tbody.appendChild(r));
    }

    searchInput.addEventListener("keyup", filterTable);
    roleFilter.addEventListener("change", filterTable);
    sortSelect.addEventListener("change", sortTable);

});
</script>


@endsection
