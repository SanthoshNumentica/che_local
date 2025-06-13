<!DOCTYPE html>
<html>
<head>
    <title>CHE</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @livewireStyles
</head>
<body class="min-h-screen bg-cover bg-center flex items-center justify-center"
      style="background-image: url('{{ asset('images/background.png') }}'); background-size: cover; background-repeat: no-repeat; background-position: center center;">

    <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-xl p-10 shadow-2xl w-full max-w-md sm:max-w-lg md:max-w-xl">
        {{ $slot }}
    </div>

    @livewireScripts
</body>
</html>
