<!DOCTYPE html>
<html lang="en">
<head>
    @include('Client.components.head')
</head>
<body>
    <div class="wrapper">

        <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
            @include('Client.components.navbar')
        </nav>

        @yield('content')
        
        <footer class="bg-light pt-5">
            @include('Client.components.footer')
        </footer>

    </div>
</body>
</html>