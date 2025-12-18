@extends('manage.admin.index')

@section('content')

{{-- Page Header --}}
<div class="mb-4">
    <h4 class="fw-bold">Trash</h4>
    <p class="text-muted small">Recover deleted users or packages.</p>
</div>

{{-- Tabs --}}
<ul class="nav nav-tabs mb-3" id="recycleTabs" role="tablist">
    <li class="nav-item">
        <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users"
            type="button" role="tab">
            <i class="fas fa-user me-1"></i> Users
        </button>
    </li>

    <li class="nav-item">
        <button class="nav-link" id="packages-tab" data-bs-toggle="tab" data-bs-target="#packages"
            type="button" role="tab">
            <i class="fas fa-store me-1"></i> Packages
        </button>
    </li>
</ul>

<div class="tab-content">

    {{-- USERS TAB --}}
    <div class="tab-pane fade show active" id="users" role="tabpanel">
        <div class="card shadow-sm">
            <div class="card-body">

                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Deleted Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usertrashs as $usertrash)
                        <tr>
                            <td>{{ $usertrash->id }}</td>
                            <td>{{ $usertrash->name }}</td>
                            <td>{{ $usertrash->email }}</td>
                            <td>{{ $usertrash->deleted_at }}</td>
                            <td>
                                <div class="d-flex gap-2">

                                    {{-- Restore --}}
                                    <form action="{{ route('trash.rollbackUser', $usertrash->id) }}" method="post">
                                        @csrf
                                        @method('post')
                                        <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                    </form>

                                    {{-- Delete Forever --}}
                                    <form action="{{ route('trash.forcedeleteUser', $usertrash->id) }}" method="post">
                                        @csrf
                                        @method('post')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-danger fw-bold">
                                Nothing in recycle bin.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    {{-- PACKAGES TAB --}}
    <div class="tab-pane fade" id="packages" role="tabpanel">
        <div class="card shadow-sm">
            <div class="card-body">

                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Package Name</th>
                            <th>Description</th>
                            <th>Deleted Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($packagetrashs as $packagetrash)
                        <tr>
                            <td>{{ $packagetrash->package_id }}</td>
                            <td>{{ $packagetrash->package_name }}</td>
                            <td>{{ $packagetrash->package_desc }}</td>
                            <td>{{ $packagetrash->deleted_at }}</td>
                            <td>
                                <div class="d-flex gap-2">

                                    {{-- Restore --}}
                                    <form action="{{ route('trash.rollbackPackageshop', $packagetrash->package_id) }}" method="post">
                                        @csrf
                                        @method('post')
                                        <button class="btn btn-success btn-sm">Restore</button>
                                    </form>

                                    {{-- Delete Forever --}}
                                    <form action="{{ route('trash.forcedeletePackageshop', $packagetrash->package_id) }}" method="post">
                                        @csrf
                                        @method('post')
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-danger fw-bold">
                                Nothing in recycle bin.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>

@endsection
