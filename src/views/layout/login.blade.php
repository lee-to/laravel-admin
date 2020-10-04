<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config("admin.title") }}</title>

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
