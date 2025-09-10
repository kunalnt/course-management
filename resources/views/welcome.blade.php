<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Course Enrollment System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: url('https://images.unsplash.com/photo-1601933475466-9d0d0a50b5f1?auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }
        .overlay {
            background: rgb(25 135 84);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .hero-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            padding: 3rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 8px 30px rgba(0,0,0,0.5);
        }
        .hero-card h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .hero-card p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }
        .btn-custom {
            width: 150px;
            margin: 0 0.5rem;
            font-weight: 600;
        }
        @media (max-width: 576px) {
            .hero-card h1 { font-size: 2rem; }
            .hero-card p { font-size: 1rem; }
            .btn-custom { width: 100%; margin-bottom: 0.5rem; }
        }
    </style>
</head>
<body>
    <div class="overlay" >
        <div class="hero-card" style="background-image: url('https://www.iihr.edu.in/wp-content/uploads/2021/07/university-background-image.png');    background-size: cover;">
            <h1><i class="bi bi-journal-bookmark-fill"></i> Course Enrollment System</h1>
            <p>Manage courses, sections, and student enrollments with ease.</p>

            @if (Route::has('login'))
                <div class="d-flex justify-content-center flex-wrap">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-custom">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-success btn-custom">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-custom">
                                <i class="bi bi-pencil-square"></i> Register
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
