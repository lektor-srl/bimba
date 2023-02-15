
<!DOCTYPE html>
<html lang="it-it">

<head>
    @include('layouts.head')
    @yield('head')
</head>

<body>
<!-- Nuovo cliente modale -->
<x-nuovo-cliente-modal></x-nuovo-cliente-modal>

<!-- Nuovo progetto modale -->
<x-nuovo-progetto-modal></x-nuovo-progetto-modal>

<nav style="background-color: rgba(0,0,0,.8)" class="uk-navbar-container uk-margin uk-navbar-transparent uk-background-primary uk-light uk-margin-remove-bottom">
    <x-topbar></x-topbar>
</nav>

@yield('page-content')

@include('layouts.footer')
@yield('footer')


</body>

</html>
