<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 100%);
            color: #e0e0ff;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
        }
        .success-card {
            background: rgba(20, 25, 45, 0.98);
            border-radius: 2rem;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 25px 70px rgba(0,0,0,0.7);
            border: 1px solid rgba(0,212,255,0.25);
        }
        .success-icon {
            font-size: 6rem;
            color: #00ff9d;
            text-shadow: 0 0 25px rgba(0,255,157,0.6);
            animation: pop 0.7s ease forwards;
        }
        @keyframes pop {
            0% { transform: scale(0.5); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .btn-store {
            background: linear-gradient(45deg, #00d4ff, #ff00ff);
            color: black;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 700;
            box-shadow: 0 15px 40px rgba(0,212,255,0.6);
            transition: 0.3s;
        }
        .btn-store:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 50px rgba(0,212,255,0.8);
        }
    </style>
</head>
<body>

@include('elements.navbar')


<div class="container my-5 d-flex justify-content-center">
    <div class="col-lg-7">

        <div class="success-card">
            <i class="fas fa-check-circle success-icon mb-4"></i>

            <h1 class="fw-bold text-white mb-3">Payment Failed!</h1>

            <p class="lead text-gray-300 mb-4">
                Payment Failed 
                Please Try Again Later!
            </p>

            <a href="{{ route('store') }}" class="btn btn-store">
                <i class="fas fa-store me-2"></i> Return to Store
            </a>
        </div>

    </div>
</div>

@include('elements.footer')

</body>
</html>






























<div class="container my-5 d-flex justify-content-center">
    <div class="col-lg-7">

        <div class="success-card">
            <i class="fas fa-check-circle success-icon mb-4"></i>

            <h1 class="fw-bold text-white mb-3">Payment Failed</h1>

            <p class="lead text-gray-300 mb-4">
               Your payment could not be completed. Please try again.
            </p>

            <a href="{{ route('store') }}" class="btn btn-store">
                <i class="fas fa-store me-2"></i> Return to Store
            </a>
        </div>

    </div>
</div>

@include('elements.footer')

</body>
</html>
