<!DOCTYPE html>
<html lang="en">
<head>
    @include('User.components.head')
</head>
<body>
    <div class="wrapper">

        <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
            @include('User.components.navbar')
        </nav>

        @yield('content')
        
        <footer class="bg-light pt-5">
            @include('User.components.footer')
        </footer>

    </div>
</body>
</html>