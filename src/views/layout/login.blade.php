<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config("admin.title") }}</title>

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('vendor/leeto-admin/apple-touch-icon.png') }}"/>
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('vendor/leeto-admin/favicon-32x32.png') }}"/>
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('vendor/leeto-admin/favicon-16x16.png') }}"/>

        <!-- Styles -->
		<link rel="stylesheet" href="https://rsms.me/inter/inter.css">

		<link rel="stylesheet" href="{{ asset('vendor/leeto-admin/css/app.css') }}">

		@yield('after-styles')
    </head>
    <body>
        <div>
            @include('admin::components.partials.alert')

            @yield('content')
        </div>

		@yield('after-scripts')

        <script src="{{ asset('vendor/leeto-admin/js/app.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    </body>
</html>
