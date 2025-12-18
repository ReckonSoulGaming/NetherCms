{{-- resources/views/manage/admin/command-sender.blade.php --}}
@extends('manage.admin.index')



@section('breadcrumb')
    <b class="breadcrumb-item">{{ config('app.name') }}</b>
    <li class="breadcrumb-item active" aria-current="page">Commander</li>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold text-gray-800 mb-1">Server Console</h1>
        <p class="mb-0 text-muted small">Execute console commands directly on your Minecraft server</p>
    </div>
    <div class="text-end">
        <span class="badge bg-success fs-6 px-4 py-2 shadow-sm">
            <i class="fas fa-server me-2"></i>
            {{ $settings->hostname }}:{{ $settings->rcon_port }}
        </span>
    </div>
</div>

<div class="row g-4">

     {{--   COMMAND INPUT --}}
    <div class="col-lg-8">
        <div class="card shadow border-0 h-100">
            <div class="card-header py-3 text-white"
                 style="background: linear-gradient(90deg, #e74a3b, #be2617);">
                <h6 class="m-0 fw-bold">Send Console Command</h6>
            </div>

            <div class="card-body p-4">

                <form action="{{ route('serverconsole') }}" method="POST">
                    @csrf

                    <label class="form-label fw-bold fs-5 mb-2">Command Input</label>

                    <div class="input-group input-group-lg mb-3">
                        <input
                            type="text"
                            name="command"
                            class="form-control fw-bold"
                            placeholder="e.g. give %player diamond 64; say &aWelcome!"
                            autofocus
                            required
                            autocomplete="off">

                        <button type="submit" class="btn btn-danger px-4 shadow-sm">
                            <i class="fas fa-paper-optione me-2"></i> Send
                        </button>
                    </div>
<div class="mb-3">
    <label class="form-label fw-bold">Run As</label>
    <select name="run_as" class="form-select" required>
        <option value="console">Console (Instant)</option>
        <option value="player">Player (Wait for Online)</option>
    </select>
</div>

                    <div class="text-muted small">
                        ✅ <code class="bg-dark text-white px-2 py-1 rounded">%player</code> → Targets your username  
                        ✅ <code class="bg-dark text-white px-2 py-1 rounded">;</code> → Separate multiple commands
                    </div>

                </form>

                {{--  OUTPUT --}}
                @if(session('command_result'))
                <div class="mt-4">
                    <h6 class="fw-bold text-success mb-2">Command Output</h6>
                    <div class="bg-black text-success p-3 rounded font-monospace shadow-sm"
                         style="max-height: 300px; overflow-y: auto;">
                        <pre class="mb-0 text-wrap">{{ session('command_result') }}</pre>
                    </div>
                </div>
                @endif

                {{--  ERROR --}}
                @if(session('command_error'))
                <div class="alert alert-danger mt-3 shadow-sm">
                    <strong>Execution Error:</strong> {{ session('command_error') }}
                </div>
                @endif

            </div>
        </div>
    </div>

     {{--   QUICK HELP --}}
    <div class="col-lg-4">
        <div class="card shadow border-0 h-100">

            <div class="card-header py-3 bg-dark text-white">
                <h6 class="m-0 fw-bold">Quick Help & Examples</h6>
            </div>

            <div class="card-body">

                <h6 class="fw-bold text-primary">Placeholders</h6>
                <ul class="list-unstyled small mb-3">
                    <li class="mb-2">
                        <code class="bg-secondary text-white px-2 py-1 rounded">%player</code> → Your username
                    </li>
                    <li>
                        <code class="bg-secondary text-white px-2 py-1 rounded">;</code> → Multiple commands
                    </li>
                </ul>

                <hr>

                <h6 class="fw-bold text-primary">Common Commands</h6>

                <div class="small mb-3">
                    <code class="d-block bg-light p-2 rounded mb-1">say &6Server restarting in 5 minutes!</code>
                    <code class="d-block bg-light p-2 rounded mb-1">give %player diamond 64</code>
                    <code class="d-block bg-light p-2 rounded mb-1">lp user %player permission set vip.true</code>
                    <code class="d-block bg-light p-2 rounded mb-1">gamemode creative %player</code>
                    <code class="d-block bg-light p-2 rounded">time set day; weather clear</code>
                </div>

                <div class="mt-3 p-3 text-white rounded shadow-sm"
                     style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <small>
                        <strong>Pro Tip:</strong>  
                        Chain unlimited commands using semicolons for promotions, kits, and events.
                    </small>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
