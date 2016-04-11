<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
<head>
    {{ Html::meta(null, null, ['charset' => 'utf-8']) }}

    {{ Html::meta('author', 'LURQUIN Michaël') }}

    {{ Html::meta(null, 'IE=edge', ['http-equiv' => 'X-UA-Compatible']) }}
    {{ Html::meta('viewport', 'width=device-width, initial-scale=1') }}

    {{ Html::favicon('favicon.ico') }}

    <title>dig | Catalogue de services</title>

    <!-- Styles CSS -->
    {{ Html::style('css/bootstrap.min.css') }}
    {{ Html::style('css/app.css') }}
</head>
<body>
    <!-- Menu de navigation -->
    @include('layouts.nav')

    <!-- Notifications -->
    @include('flash.message')

    <!-- Contenu de la page (que l'on peut modifier) -->
    <div class="container">
        <div class="col-md-12">
            @yield('content')
        </div>
    </div>

    <!-- Bloc en bas de page, pour afficher le copyright, l'année et le nom du projet -->
    @include('layouts.footer')

    <!-- Scripts JS -->
    {{ Html::script('js/jquery-2.2.2.min.js') }}
    {{ Html::script('js/bootstrap.min.js') }}
    {{ Html::script('js/app.js') }}
</body>
</html>
