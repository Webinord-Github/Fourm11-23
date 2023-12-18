<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light only">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tiny.cloud/1/rwzq3ta3q8axewq6bhxjvieo3wqy16dgu4ab1wo2xu3pba2c/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js','public/css/elementor.css'])
</head>

<body class="font-sans antialiased">
    <div class="popup">
        <div class="medias-library">
            <div class="close-btn">
                <i class="fa-solid fa-xmark" style="color: #fff;"></i>
            </div>
            <h2>Bibliothèque d'images</h2>
            <div id="drop-area" class="content">
                <div id="drop-over">
                    <p>Téléverser une image</p>
                </div>
                <div id="library" class="medias"></div>
                <div class="options library-options">
                    <h3>Options d'image</h3>
                    <div class="default">
                        <p>Sélectionner une image pour la modifier</p>
                        <i class="fa-solid fa-arrow-turn-down fa-rotate-90 fa-xl" style="color: #ffffff;"></i>
                    </div>
                    <div class="image-options hidden">
                        <p class="image-name"></p>
                        <p class="size"></p>
                        <p class="extension"></p>
                        <p class="dimensions"></p>
                        <div class="buttons">
                            <p id="chosen-one" class="button">Sélectionner</p>
                        </div>
                        <form name="dragdrop">
                            @csrf
                            <input type="file" id="uploaded_file" name="uploaded_file">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="min-h-screen bg-gray-100">
        @include('layouts.adminnav')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            @include('admin.partials.elementorblocs')

            @yield('content')
        </main>
    </div>
    @yield('scripts')
</body>

</html>