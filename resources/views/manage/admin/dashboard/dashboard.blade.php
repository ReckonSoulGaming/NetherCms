{{-- resources/views/manage/admin/dashboard.blade.php --}}
@extends('manage.admin.index')

@section('title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/manage">{{ Auth::user()->name }}</a></li>
    <li class="breadcrumb-item"><a href="/manage">Admin</a></li>
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Dashboard Overview</h1>
        <p class="text-muted mb-0">Live overview of your store & server activity</p>
    </div>
</div>

 {{--   STAT CARDS --}}
<div class="row g-4 mb-4">

     {{--  USERS --}}
    <div class="col-xl-3 col-md-6">
        <div class="card text-white h-100 shadow border-0"
             style="background:linear-gradient(135deg,#4e73df,#224abe); border-radius:18px;">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="small text-uppercase fw-semibold opacity-75">Players</div>
                    <div class="h2 fw-bold mb-0">{{ number_format(count($users)) }}</div>
                </div>
                <i class="fas fa-users fa-3x opacity-25"></i>
            </div>
        </div>
    </div>

     {{--  PACKAGES --}}
    <div class="col-xl-3 col-md-6">
        <div class="card text-white h-100 shadow border-0"
             style="background:linear-gradient(135deg,#1cc1a1,#0f9b80); border-radius:18px;">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="small text-uppercase fw-semibold opacity-75">Packages</div>
                    <div class="h2 fw-bold mb-0">{{ number_format(count($packages)) }}</div>
                </div>
                <i class="fas fa-gem fa-3x opacity-25"></i>
            </div>
        </div>
    </div>

     {{--  ANNOUNCEMENTS --}}
    <div class="col-xl-3 col-md-6">
        <div class="card text-dark h-100 shadow border-0"
             style="background:linear-gradient(135deg,#ffc107,#ff9800); border-radius:18px;">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="small text-uppercase fw-semibold opacity-75">Announcements</div>
                    <div class="h2 fw-bold mb-0">{{ number_format(count($alerts)) }}</div>
                </div>
                <i class="fas fa-bullhorn fa-3x opacity-25"></i>
            </div>
        </div>
    </div>

     {{--  SOLD --}}
    <div class="col-xl-3 col-md-6">
        <div class="card text-white h-100 shadow border-0"
             style="background:linear-gradient(135deg,#dc3545,#a51827); border-radius:18px;">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="small text-uppercase fw-semibold opacity-75">Sold</div>
                    <div class="h2 fw-bold mb-0">{{ number_format($all_sold_packages) }}</div>
                </div>
                <i class="fas fa-shopping-cart fa-3x opacity-25"></i>
            </div>
        </div>
    </div>

</div>

 {{--   SUMMARY PANEL --}}
<div class="row g-4">
    <div class="col-12">
        <div class="card shadow border-0 content-card">
            <div class="card-header py-3 d-flex justify-content-between align-items-center"
                 style="background:linear-gradient(90deg,#4e73df,#224abe);">
                <h6 class="fw-bold text-white mb-0">Finance & Server Summary</h6>
                <i class="fas fa-chart-pie text-white opacity-75"></i>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <tbody>

                            <tr>
                                <td class="fw-bold">Total Revenue</td>
                                <td class="text-end">
                                    <span class="fs-4 fw-bold text-success">
                                     {{ currency_symbol() }}{{ number_format(currency_convert($all_payment_amount), 2) }}

                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td>Forum Threads</td>
                                <td class="text-end fw-semibold">1,248</td>
                            </tr>

                            <tr>
                                <td>Players Online</td>
                                <td class="text-end">
                                    <span class="badge bg-success fs-6 px-4 py-2">
                                       COMING SOON
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td>D</td>
                                <td class="text-end fw-bold text-primary">
                                   
                                </td>
                            </tr>

                           

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
