<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .carousel-item img {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }
        .navbar {
            background-color: rgb(44, 36, 36); /* Dark background */
        }
        .navbar-nav .nav-link {
            color: white !important; /* White text for nav links */
        }
        .navbar .btn-outline-light {
            color: white;
            border-color: white;
        }
    </style>
    <meta name="csrf-token" content = "{{csrf_token() }}">

@yield('head')