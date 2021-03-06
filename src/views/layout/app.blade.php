<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('vendor/leeto-admin/apple-touch-icon.png') }}"/>
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('vendor/leeto-admin/favicon-32x32.png') }}"/>
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('vendor/leeto-admin/favicon-16x16.png') }}"/>

        <!-- Styles -->
		<link rel="stylesheet" href="https://rsms.me/inter/inter.css">

		<link rel="stylesheet" href="{{ asset('vendor/leeto-admin/css/app.css') }}">

        @if(isset($resource) && $resource->getAssets("css"))
            @foreach($resource->getAssets("css") as $css)
                <link rel="stylesheet" href="{{ asset($css) }}">
            @endforeach
        @endif

		@yield('after-styles')
    </head>
    <body>
        <!-- component -->
        <div>
            @include('admin::components.partials.alert')

            <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
                @section("sidebar")
                    @include('admin::partials.sidebar')
                @show

                <div class="flex-1 flex flex-col overflow-hidden">
                    @section("header")
                        @include('admin::partials.header')
                    @show

                    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                        <div class="mx-auto py-8 px-8">
                            @yield('content')
                        </div>
                    </main>
                </div>
            </div>
        </div>

        @include('admin::partials.popups')

		@yield('after-scripts')
		
		<script src="{{ asset('vendor/leeto-admin/js/app.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

        @if(isset($resource) && $resource->getAssets("js"))
            @foreach($resource->getAssets("js") as $js)
                <script src="{{ asset($js) }}"></script>
            @endforeach
        @endif
    </body>
</html>
