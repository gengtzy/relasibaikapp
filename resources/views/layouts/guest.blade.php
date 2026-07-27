@props([
    'bgImage' => 'images/default-bg.svg',
    'centered' => false,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
    darkMode: localStorage.getItem('darkMode') === 'true'
}" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
    :class="{ 'dark': darkMode }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RelasiBaik') }} - Cek Kualitas Hubungan Keluarga</title>
    <meta name="description" content="Aplikasi screening kualitas relasi keluarga Indonesia berbasis psikologi. Cek keterlibatan ayah, ibu, dan anak secara objektif.">
    <meta name="keywords" content="relasi keluarga, psikologi, tes hubungan, parenting, relasibaik">
    <meta name="author" content="Ageng Puji Pangestu">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <meta property="og:type" content="website">
    <meta property="og:title" content="RelasiBaik - Ukur Keharmonisan Keluargamu">
    <meta property="og:description" content="Dapatkan analisis psikologi keluarga secara gratis dan akurat di sini.">
    <meta property="og:image" content="{{ asset('images/bgall3.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <link rel="shortcut icon" href="{{ asset('images/Logorelasibaik.svg') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://unpkg.com">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        function setTheme() {
            if (localStorage.getItem('darkMode') === 'true' ||
                (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
        setTheme();
        document.addEventListener('livewire:navigated', () => {
            setTheme();
        });
    </script>

    @livewireStyles
    @stack('styles')
</head>

<body class="min-h-screen bg-cover bg-no-repeat bg-white dark:bg-slate-800 transition-colors duration-500 ease-in-out overflow-x-hidden"
    style="background-image:url('{{ asset($bgImage ?? 'images/default-bg.svg') }}')">
    {{ $slot }}
</body>
@stack('scripts')

</html>
