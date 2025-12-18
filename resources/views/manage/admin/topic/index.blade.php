{{-- resources/views/manage/topicmanager/index.blade.php --}}
@extends('manage.admin.index')

@section('title', 'My Topics')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 fw-bold">My Topics</h1>
        <p class="text-muted small">Manage your forum posts and deleted topics</p>
    </div>
</div>

<div class="card shadow-lg border-0 overflow-hidden">
    <div class="card-header py-4 text-white text-center fw-bold"
         style="background: linear-gradient(90deg, #4e73df, #224abe);">
        <h5 class="mb-0">Forum Topic Manager</h5>
    </div>

    <div class="card-body p-4 p-lg-5">

        {{-- Tabs --}}
        <ul class="nav nav-tabs mb-4 border-0" id="topicTabs">
            <li class="nav-item">
                <button class="nav-link active fw-bold px-4 py-2" data-bs-toggle="tab" data-bs-target="#allTopics">
                    All Topics <span class="badge bg-light text-dark ms-2">{{ $topics->count() }}</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link fw-bold px-4 py-2" data-bs-toggle="tab" data-bs-target="#trashTopics">
                    Trash <span class="badge bg-light text-dark ms-2">{{ $deletedtopics->count() }}</span>
                </button>
            </li>
        </ul>

        <div class="tab-content">

            {{-- ALL TOPICS --}}
            <div class="tab-pane fade show active" id="allTopics">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Topic</th>
                                <th class="text-center">Views</th>
                                <th class="text-center">Replies</th>
                                <th class="text-center" style="width:180px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topics as $topic)
                                <tr>
                                    <td class="fw-semibold">
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            {{ $topic->topic_title }}
                                            @if($topic->role_id == 1)
                                                <span class="badge bg-danger small">Admin</span>
                                            @elseif($topic->role_id == 2)
                                                <span class="badge bg-primary small">Player</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center text-muted">{{ $topic->topic_views }}</td>
                                    <td class="text-center text-muted">{{ $topic->comments->count() }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('topic.show', $topic->topic_id) }}"
                                               class="btn btn-sm btn-outline-dark">
                                                View
                                            </a>
                                            <form method="POST" action="{{ route('topicmanager.destroy', $topic->topic_id) }}"
                                                  class="d-inline" onsubmit="return confirm('Move to trash?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    Trash
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-6">
                                        <i class="fas fa-file-alt fa-4x text-muted opacity-30 mb-4"></i>
                                        <h5 class="text-muted mb-2">No topics yet</h5>
                                        <p class="text-muted small">
                                            <a href="{{ route('topic.create') }}" class="text-primary fw-bold">Create your first topic!</a>
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- TRASH TAB --}}
            <div class="tab-pane fade" id="trashTopics">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Topic</th>
                                <th class="text-center">Views</th>
                                <th class="text-center">Replies</th>
                                <th class="text-center" style="width:180px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deletedtopics as $topic)
                                <tr class="table-secondary">
                                    <td class="fw-semibold text-muted">{{ $topic->topic_title }}</td>
                                    <td class="text-center text-muted">{{ $topic->topic_views }}</td>
                                    <td class="text-center text-muted">{{ $topic->comments->count() }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <form action="{{ route('topicmanager.restore', $topic->topic_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    Restore
                                                </button>
                                            </form>
                                            <form action="{{ route('topicmanager.forcedelete', $topic->topic_id) }}" method="POST"
                                                  class="d-inline" onsubmit="return confirm('Permanently delete?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-6">
                                        <i class="fas fa-trash fa-4x text-muted opacity-30 mb-4"></i>
                                        <h5 class="text-muted mb-2">Trash is empty</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Perfect responsive fix + style --}}
<style>
    .bg-gradient-primary {
        background: linear-gradient(90deg, #4e73df, #224abe) !important;
    }

    /* Make table fully responsive */
    .table-responsive {
        border-radius: 12px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* On mobile: make columns stack nicely */
    @media (max-width: 768px) {
        table thead { display: none; }
        table tr {
            border: 0;
        }
        table tbody tr {
            display: block;
            margin-bottom: 1.5rem;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 1rem;
            background: white;
        }
        table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            border: none;
            text-align: right;
        }
        table tbody td:before {
            content: attr(data-label);
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.8rem;
            color: #6c757d;
            text-align: left;
            flex: 1;
        }
        table tbody td:last-child { border-bottom: none; }
    }

    /* Hover effects */
    .table-hover tbody tr:hover {
        background-color: #f0f5ff !important;
    }
    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 2rem 4rem rgba(0,0,0,.22) !important;
        transition: all 0.4s ease;
    }
</style>

{{-- Make mobile table readable --}}
<script>
    document.querySelectorAll('table tbody td').forEach(cell => {
        const headers = ['Topic', 'Views', 'Replies', 'Actions'];
        const index = Array.from(cell.parentNode.children).indexOf(cell);
        if (window.innerWidth < 768) {
            cell.setAttribute('data-label', headers[index] + ': ');
        }
    });
</script>

@endsection