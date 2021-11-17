<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>My first BootstrapVue app</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link href="{{asset('argon/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link type="text/css" rel="stylesheet" href="https://unpkg.com/bootstrap/dist/css/bootstrap.min.css"/>
        <link type="text/css" rel="stylesheet" href="https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.css"/>
        <!-- Argon CSS -->
        <link type="text/css" href="{{asset('argon/assets/css/argon.min.css')}}" rel="stylesheet">
        {{ $styleSheets }}
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <div class="z-20 fixed w-full shadow-sm" onclick="appAdmin.showSidebar = !appAdmin.showSidebar">
                @include('layouts.navigation')
            </div><br><br>
            <!-- Page Heading -->
            <header onclick="appAdmin.showSidebar = false" class="bg-white shadow">
                <div class="bg-cover bg-center d-flex flex-row-reverse  h-auto text-white py-24 px-10 object-fill self-end" style="background-image: url({{ $imgHeader }})">
                    <div class="relative md:w-2/3 z-50">
                        <p class="absolute bottom-4 px-1 text-md text-default font-bold bg-secondary rounded-sm shadow-xl overflow-hidden md:max-w-xs">{{ $titleHeader }}</p>
                        <p class="absolute bottom-5 p-2 text-3xl font-bold bg-primary rounded-xs shadow-xl overflow-hidden md:max-w-sm">{{ $parHeader }}</p>
                    </div>
                 </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $content }}
            </main>
        </div>
        <!-- Scripts -->
        <script src="https://polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver"></script>
        <script src="https://unpkg.com/vue@latest/dist/vue.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js" integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.js"></script>
        {{ $scripts }}
        <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
</html>
