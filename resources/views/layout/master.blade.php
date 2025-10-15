 @include('layout.header')
 @include('layout.sidebar')

 <div class="container-fluid">
        <div class="row">
 <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
@yield('content')
</main>
        </div>
    </div>
@include('layout.footer')
