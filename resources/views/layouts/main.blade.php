<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Meta tags essentiels -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- SEO Meta tags -->
    <title>{{ config('app.name', 'Laravel') }} | @yield('title', 'Accueil')</title>
    <meta name="description"
          content="@yield('meta_description', 'Une application moderne et intuitive
 conçue pour simplifier la gestion des écoles. Elle offre
  des fonctionnalités complètes pour gérer les
  rôles administratifs, les enseignants, les étudiants, les cours, les emplois du
 temps, les résultats, et bien plus encore.
 Grâce à une interface conviviale et une intégration
  fluide des données, l\'application optimise
  les processus administratifs et améliore l\'expérience utilisateur pour tous les acteurs
  impliqués dans le système éducatif')">
    <meta name="keywords" content="@yield('meta_keywords', 'mots-clés, par, défaut')">
    <meta name="author" content="@yield('meta_author', 'Owr Digi')">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="{{ config('app.name', 'Laravel') }} | @yield('title', 'Accueil')">
    <meta property="og:description"
          content="@yield('meta_description', 'Une application moderne et intuitive conçue pour simplifier
la gestion des écoles. Elle offre des fonctionnalités complètes pour gérer les rôles administratifs,
les enseignants, les étudiants, les cours, les emplois du temps, les résultats, et bien plus encore.
 Grâce à une interface conviviale et une intégration fluide des données, l\'application optimise les
  processus administratifs et améliore l\'expérience utilisateur pour tous les acteurs impliqués
  dans le système éducatif')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('meta_image', asset('img/default-og-image.jpg'))">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon.png') }}">

    <!-- Préchargement des ressources critiques -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- CSS Principal -->
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{asset('css/all.min.css')}}">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="{{asset('fonts/flaticon.css')}}">
    <!-- Full Calender CSS -->
    <link rel="stylesheet" href="{{asset('css/fullcalendar.min.css')}}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{asset('css/animate.min.css')}}">
    <!-- Custom CSS -->
    <!-- Select 2 CSS -->
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <!-- Date Picker CSS -->
    <link rel="stylesheet" href="{{asset('css/datepicker.min.css')}}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('style.css')}}">
    <!-- Modernize js -->
    <script src="{{asset('js/modernizr-3.6.0.min.js')}}"></script>
</head>

<body>
<!-- Preloader Start Here -->
<div id="preloader"></div>
<!-- Preloader End Here -->
<div id="wrapper" class="wrapper bg-ash">
    <!-- Header Menu Area Start Here -->
    @include('partails.header')
    <!-- Header Menu Area End Here -->
    <!-- Page Area Start Here -->
    <div class="dashboard-page-one">
        <!-- Sidebar Area Start Here -->
        @include('partails.sidebar')
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            @yield('content')
            <!-- Footer Area Start Here -->
            @include('partails.footer')
            <!-- Footer Area End Here -->
        </div>
    </div>
    <!-- Page Area End Here -->
</div>
<!-- jquery-->
<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<!-- Plugins js -->
<script src="{{asset('js/plugins.js')}}"></script>
<!-- Popper js -->
<script src="{{asset('js/popper.min.js')}}"></script>
<!-- Bootstrap js -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<!-- Counterup Js -->
<!-- Select 2 Js -->
<script src="{{asset('js/select2.min.js')}}"></script>
<!-- Date Picker Js -->
<script src="{{asset('js/datepicker.min.js')}}"></script>
<!-- Smoothscroll Js -->
<script src="{{asset('js/jquery.counterup.min.js')}}"></script>
<!-- Moment Js -->
<script src="{{asset('js/moment.min.js')}}"></script>
<!-- Waypoints Js -->
<script src="{{asset('js/jquery.waypoints.min.js')}}"></script>
<!-- Scroll Up Js -->
<script src="{{asset('js/jquery.scrollUp.min.js')}}"></script>
<!-- Full Calender Js -->
<script src="{{asset('js/fullcalendar.min.js')}}"></script>
<!-- Chart Js -->
<script src="{{asset('js/Chart.min.js')}}"></script>
<!-- Custom Js -->
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>


<script>
    @if(Session::has('success'))
    toastr.success("{{ Session::get('success') }}");
    @endif

    @if(Session::has('error'))
    toastr.error("{{ Session::get('error') }}");
    @endif
</script>

@yield('scripts')
</body>
</html>
