<!DOCTYPE html>
<html lang="en">
<head>
   @include('Admin.components.head')
</head>
<body class="sidebar-mini sidebar-closed sidebar-collapse" style="height:auto">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto"> 
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    @include('Admin.components.sidebar')
    <div class="content-wrapper" style="min-height: 2171.31px">
      <section class="content">
        <div class="container-fluid">
        @include('Admin.components.alert')
          <div class="row">
            <div class="col-md-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">{{$title}}</small></h3>
                </div>
              </div>  
                  @yield('content')
            </div>     
          </div>      
        </div>
      </section>
    </div>
    <aside class="control-sidebar control-sidebar-dark" style="display: none">
    @include('Admin.components.footer')
  </div>
</body>
</html>


