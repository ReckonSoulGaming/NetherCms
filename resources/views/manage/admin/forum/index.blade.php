{{-- resources/views/manage/admin/forum/category/index.blade.php --}}
@extends('manage.admin.index')

@section('title', 'Forum Categories')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('profile.index') }}">{{ Auth::user()->name }}</a></li>

    <li class="breadcrumb-item"><a href="{{ route('forumcontrol.index') }}">Forum</a></li>
    <li class="breadcrumb-item active" aria-current="page">Categories</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Forum Categories</h1>
        <p class="mb-0 text-muted small">Manage categories used in your community forum</p>
    </div>
    <a href="{{ route('forumcontrol.create') }}" class="btn btn-success shadow-sm btn-lg">
        Add Category
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-header py-3" style="background: linear-gradient(90deg, #4e73df, #224abe);">
        <h6 class="m-0 font-weight-bold text-white mb-0">All Forum Categories</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Category Name</th>
                        <th>Description</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold">{{ $category->forum_category_name }}</div>
                        </td>
                        <td>
                            <span class="text-muted">{{ $category->forum_category_description ?: '—' }}</span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('forumcontrol.edit', $category->forum_category_id) }}"
                                   class="btn btn-info btn-sm shadow-sm">
                                    Edit
                                </a>
                                <form action="{{ route('forumcontrol.destroy', $category->forum_category_id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this forum category permanently?')">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm shadow-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-6">
                            <div class="text-muted">
                                <i class="fas fa-comments fa-4x mb-4 opacity-50"></i>
                                <div class="h5 mb-1">No forum categories yet</div>
                                <small>Create your first category using the button above!</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection