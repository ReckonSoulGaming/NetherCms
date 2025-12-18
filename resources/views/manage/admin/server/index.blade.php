@extends('manage.admin.index')



@section('breadcrumb')
    <b class="breadcrumb-item">{{ config('app.name') }}</b>
    <li class="breadcrumb-item active" aria-current="page">Game Server</li>
@endsection

@section('content')

<style>
/* GLOBAL POLISH */
.card {
    border-radius: 18px !important;
}
.card-header {
    border-top-left-radius: 18px !important;
    border-top-right-radius: 18px !important;
}
.form-control,
.form-select {
    min-height: 48px;
    border-radius: 12px;
}
.badge {
    border-radius: 10px;
}

/* MOBILE RESPONSIVE TABLE */
@media (max-width: 768px) {
    table thead { display: none; }
    table tbody tr {
        display: block;
        margin-bottom: 12px;
        padding: 14px;
        border: 1px solid #ddd;
        border-radius: 14px;
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
        <h1 class="h3 mb-1 fw-bold text-gray-800">Server Settings</h1>
        <p class="mb-0 text-muted">Manage and configure multiple Server Settings</p>
    </div>
    <button type="button" class="btn btn-success btn-lg shadow-sm px-4"
            data-bs-toggle="modal" data-bs-target="#addServerModal">
        <i class="fas fa-plus me-2"></i>Add Server
    </button>
</div>

 {{--  SEARCH / FILTER / SORT --}}
<div class="card shadow mb-3 border-0">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-md-4 col-12">
                <input id="searchInput" type="text" class="form-control" placeholder="Search servers...">
            </div>

            <div class="col-md-4 col-12">
                <select id="portFilter" class="form-select">
                    <option value="">All (Ports)</option>
                    <option value="has_rcon">Has RCON</option>
                    <option value="has_websender">Has WebSender</option>
                </select>
            </div>

            <div class="col-md-4 col-12">
                <select id="sortColumn" class="form-select">
                    <option value="">Sort By</option>
                    <option value="id">ID (Low–High)</option>
                    <option value="name">Name (A–Z)</option>
                    <option value="port">Port (Low–High)</option>
                </select>
            </div>
        </div>
    </div>
</div>

 {{--  SERVERS TABLE --}}
<div class="card shadow border-0 mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center"
         style="background: linear-gradient(90deg, #4e73df, #224abe);">
        <h6 class="fw-bold text-white mb-0">All Servers</h6>
        <span class="badge bg-light text-dark fs-6">
            {{ count($servers) }} server{{ count($servers) !== 1 ? 's' : '' }}
        </span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th class="ps-4">ID</th>
                    <th>Server Name</th>
                    <th>Address</th>
                    <th>Port</th>
                    <th>Query</th>
                    <th>RCON</th>
                    <th>WebSender</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>

                <tbody id="serversTable">
                @forelse($servers as $server)
                    <tr data-name="{{ strtolower($server->server_name) }}"
                        data-port="{{ $server->hostname_port ?? '' }}"
                        data-has-rcon="{{ $server->rcon_port ? '1' : '0' }}"
                        data-has-websender="{{ $server->websender_port ? '1' : '0' }}">

                        <td data-label="ID" class="ps-4 fw-bold">#{{ $server->server_id }}</td>

                        <td data-label="Server Name" class="fw-bold">
                            {{ $server->server_name }}
                        </td>

                        <td data-label="Address">
                            <code class="bg-dark text-white px-2 py-1 rounded">
                                {{ $server->hostname }}
                            </code>
                        </td>

                        <td data-label="Port">
                            <span class="badge bg-primary">{{ $server->hostname_port }}</span>
                        </td>

                        <td data-label="Query Port">
                            <span class="badge bg-info text-dark">{{ $server->hostname_query_port }}</span>
                        </td>

                        <td data-label="RCON Port">
                            <span class="badge bg-warning text-dark">{{ $server->rcon_port }}</span>
                        </td>

                        <td data-label="WebSender">
                            <span class="badge bg-success">{{ $server->websender_port }}</span>
                        </td>

                        <td data-label="Actions" class="text-center">
                            <button class="btn btn-info btn-sm me-1 shadow-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editServerModal-{{ $server->server_id }}">
                                Edit
                            </button>

                            <button class="btn btn-warning btn-sm me-1 shadow-sm"
                                    onclick="testConnection({{ $server->server_id }}, '{{ addslashes($server->server_name) }}', '{{ $server->hostname }}')">
                                Test
                            </button>

                            <form action="{{ route('server.doDelete') }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Delete this server permanently?')">
                                @csrf
                                <input type="hidden" name="id" value="{{ $server->server_id }}">
                                <button type="submit" class="btn btn-danger btn-sm shadow-sm">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-server fa-4x mb-3"></i>
                            <div class="h5">No servers found</div>
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>





{{-- ADD SERVER MODAL --}}
<div class="modal fade" id="addServerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Add New Server</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('server.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label fw-bold">Server Name <span class="text-danger">*</span></label><input type="text" name="server_name" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Hostname <span class="text-danger">*</span></label><input type="text" name="hostname" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Port <span class="text-danger">*</span></label><input type="number" name="hostname_port" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Query Port <span class="text-danger">*</span></label><input type="number" name="hostname_query_port" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold">RCON Port</label><input type="number" name="rcon_port" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label fw-bold">RCON Password</label><input type="text" name="rcon_password" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label fw-bold">WebSender Port</label><input type="number" name="websender_port" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label fw-bold">WebSender Password</label><input type="text" name="websender_password" class="form-control"></div>
                    </div>
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-5">Create Server</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- EDIT SERVER MODALS --}}
@foreach($servers as $server)
<div class="modal fade" id="editServerModal-{{ $server->server_id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Edit Server: {{ $server->server_name }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('server.doUpdate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $server->server_id }}">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label fw-bold">Server Name</label><input type="text" name="server_name" class="form-control" value="{{ $server->server_name }}"></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Hostname</label><input type="text" name="hostname" class="form-control" value="{{ $server->hostname }}"></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Port</label><input type="number" name="hostname_port" class="form-control" value="{{ $server->hostname_port }}"></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Query Port</label><input type="number" name="hostname_query_port" class="form-control" value="{{ $server->hostname_query_port }}"></div>
                        <div class="col-md-6"><label class="form-label fw-bold">RCON Port</label><input type="number" name="rcon_port" class="form-control" value="{{ $server->rcon_port }}"></div>
                        <div class="col-md-6"><label class="form-label fw-bold">RCON Password</label><input type="text" name="rcon_password" class="form-control" value="{{ $server->rcon_password }}"></div>
                        <div class="col-md-6"><label class="form-label fw-bold">WebSender Port</label><input type="number" name="websender_port" class="form-control" value="{{ $server->websender_port }}"></div>
                        <div class="col-md-6"><label class="form-label fw-bold">WebSender Password</label><input type="text" name="websender_password" class="form-control" value="{{ $server->websender_password }}"></div>
                    </div>
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-info btn-lg px-5">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

{{-- SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
// Test connection and show a nicer modal result instead of simple alerts
function testConnection(id, name, host) {
    // simple loading feedback
    const title = "Testing connection to " + name;
    const modalHtml = `
        <div class="modal fade" id="serverTestModal" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title">${title}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body text-center" id="serverTestBody">
                <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                <div class="mt-3">Attempting to connect to <strong>${host}</strong>...</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>`;
    // append and show
    const wrapper = document.createElement('div');
    wrapper.innerHTML = modalHtml;
    document.body.appendChild(wrapper);
    const serverTestModal = new bootstrap.Modal(document.getElementById('serverTestModal'));
    serverTestModal.show();

    axios.get('/api/connectserver/' + id)
        .then(res => {
            const body = document.getElementById('serverTestBody');
            if (res.data === true || (res.data && res.data.success)) {
                body.innerHTML = `<div class="text-success"><i class="fas fa-check-circle fa-3x"></i><div class="mt-3">Connected to <strong>${name}</strong></div></div>`;
            } else {
                body.innerHTML = `<div class="text-danger"><i class="fas fa-times-circle fa-3x"></i><div class="mt-3">Cannot connect to <strong>${name}</strong></div><pre class="mt-2">${res.data && res.data.message ? res.data.message : 'No response'}</pre></div>`;
            }
        })
        .catch(err => {
            const body = document.getElementById('serverTestBody');
            body.innerHTML = `<div class="text-danger"><i class="fas fa-exclamation-triangle fa-3x"></i><div class="mt-3">Error testing connection.</div><pre class="mt-2">${err.message}</pre></div>`;
        })
        .finally(() => {
            // auto remove modal after 6 seconds
            setTimeout(() => {
                const m = document.getElementById('serverTestModal');
                if (m) {
                    const bs = bootstrap.Modal.getInstance(m);
                    if (bs) bs.hide();
                    m.parentElement.remove();
                }
            }, 6000);
        });
}

// SEARCH / FILTER / SORT
document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchInput");
    const portFilter = document.getElementById("portFilter");
    const sortSelect = document.getElementById("sortColumn");
    const tbody = document.getElementById("serversTable");

    function getRows() {
        return [...tbody.querySelectorAll("tr")];
    }

    function filterTable() {
        const text = searchInput.value.toLowerCase();
        const port = portFilter.value;

        getRows().forEach(row => {
            const name = row.getAttribute("data-name") || "";
            const hasRcon = row.getAttribute("data-has-rcon") === '1';
            const hasWeb = row.getAttribute("data-has-websender") === '1';

            let visible = true;
            if (text && !name.includes(text)) visible = false;
            if (port === 'has_rcon' && !hasRcon) visible = false;
            if (port === 'has_websender' && !hasWeb) visible = false;

            row.style.display = visible ? "" : "none";
        });
    }

    function sortTable() {
        const type = sortSelect.value;
        const rows = getRows();
        let sorted = [...rows];

        if (type === 'id') {
            sorted.sort((a,b) => {
                const ai = parseInt(a.querySelector("td[data-label='ID']").innerText.replace('#','')) || 0;
                const bi = parseInt(b.querySelector("td[data-label='ID']").innerText.replace('#','')) || 0;
                return ai - bi;
            });
        }

        if (type === 'name') {
            sorted.sort((a,b) => a.getAttribute('data-name').localeCompare(b.getAttribute('data-name')));
        }

        if (type === 'port') {
            sorted.sort((a,b) => {
                const ap = parseInt(a.getAttribute('data-port')||0);
                const bp = parseInt(b.getAttribute('data-port')||0);
                return ap - bp;
            });
        }

        sorted.forEach(r => tbody.appendChild(r));
    }

    searchInput.addEventListener('keyup', filterTable);
    portFilter.addEventListener('change', filterTable);
    sortSelect.addEventListener('change', sortTable);
});
</script>

@endsection