<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Finatrack</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<style>
    body {
        font-family: 'Poppins', sans-serif; /* Apply Poppins font */
        background-color: #e6f1fa;
        justify-content: center;
        align-items: center;
        display: flex;
        flex-direction: column;
    }

    .chart-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 15px; /* Space between charts */
    }

    .chart-card {
        flex: 1 1 calc(50% - 15px); /* Two charts per row, responsive */
        max-width: calc(50% - 15px);
        min-width: 250px;
    }

    .navbar {
        background-color: #161a24;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    canvas {
        max-height: 200px;
    }

    .navbar a.nav-link {
        color: #ffffff !important; /* White text */
        font-weight: normal;
        position: relative;
        transition: all 0.3s ease;
    }

    .navbar a.nav-link.active {
        font-weight: bold; /* Bold text for active link */
    }

    .navbar a.nav-link:hover::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: -5px;
        height: 3px;
        background-color: #ffffff; /* White underline on hover */
        animation: moveRight 0.3s forwards;
    }

    .navbar a.nav-link::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: -5px;
        height: 3px;
        background-color: transparent; /* No underline by default */
        transition: all 0.3s ease;
    }

    @keyframes moveRight {
        from {
            width: 0%;
            left: 0;
        }
        to {
            width: 100%;
            left: 0;
        }
    }

    .gradient-nav {
        background: linear-gradient(to right, #22c55e, #3b82f6); /* Green (#22c55e) to Blue (#3b82f6) */
        color: white; /* White text */
        border: none;
        padding: 10px 20px;
        border-radius: 8px; /* Slightly rounded corners */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

     .gradient-btn {
         background: linear-gradient(to right, #22c55e, #3b82f6); /* Green (#22c55e) to Blue (#3b82f6) */
         color: white; /* White text */
         border: none;
         padding: 10px 20px;
         font-size: 14px;
         font-weight: bold;
         border-radius: 8px; /* Slightly rounded corners */
         transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth hover animation */
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow */
     }

    .gradient-btn:hover {
        transform: translateY(-2px); /* Hover lift effect */
        color: white; !important;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Increased shadow on hover */
        cursor: pointer; /* Pointer cursor for button */
    }

    .gradient-btn:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5); /* Focus ring for accessibility */
    }

    .card-user {
        background-color: #f8f9fa;
        width: 18rem;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
        justify-content: center;
        align-items: center;
        margin: 0 auto; /* This centers the card horizontally */
    }

    .card-user:hover {
        transform: translateY(-0.5px); /* Hover lift effect */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Increased shadow on hover */
        cursor: pointer; /* Pointer cursor for button */
    }

    .card-user-body {
        position: relative;
    }
    .card img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
    }
    .green-circle {
        position: absolute;
        bottom: 2px;
        right: 5px;
        width: 20px;
        height: 20px;
        background-color: #28a745;
        border-radius: 50%;
        border: 2px solid #fff;
    }

    .btn-info{
        border-radius: 50%;
        border: solid #fff;
    }


    .btn-danger{
        border-radius: 50%;
        border: solid #fff;
    }

</style>
<body>
<div class="container my-4">

    <!-- Nav Bar -->
    <nav class="navbar navbar-expand-lg mb-4 gradient-nav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{asset('images/logo.png')}}" alt="Brand Logo" style="height: 80px;">
                <span class="text-white font-weight-bold">Finatrack.</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-circle-down" style="color: #7be582; font-size: 1.5rem;"></i>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('incomeForm') ? 'active' : '' }}" href="{{ route('incomeForm') }}">Income</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('expenseForm') ? 'active' : '' }}" href="{{ route('expenseForm') }}">Expense</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('savingForm') ? 'active' : '' }}" href="{{ route('savingForm') }}">Saving</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="card card-user mb-4">
        <div class="card-body card-user-body">
            <!-- Profile Image -->
            <div class="position-relative mt-2 mb-4">
                <img src="{{ asset('images/syakirr.jpeg') }}">
                <!-- Green Online Indicator -->
                <div class="green-circle"></div>
            </div>
            <!-- Greeting Text -->
            <h5 class="card-title font-weight-bold">Hi, Syakir!</h5>
        </div>
    </div>

    {{$slot}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
</div>
<footer class="text-center">
    <p>Copyright &#169; 2024 Muadzam Arief.<br> All Rights Reserved.</p>
</footer>
</body>
</html>
