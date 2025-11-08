<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - RelasiBaik</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body>

    <livewire:layout.navigation-admin />

    <main class="bg-slate-100 p-4 sm:ml-64 min-h-screen">
        <div class="p-4 mt-14 relative overflow-x-auto">
            {{ $slot }}
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    @livewireScripts

    <script>
        // Ini akan berjalan setiap kali halaman baru dimuat via wire:navigate
        document.addEventListener('livewire:navigated', () => {
            // Inisialisasi ulang semua komponen Flowbite
            initFlowbite();
        });

        // Ini akan berjalan setiap kali Livewire melakukan update di halaman
        // (misalnya, setelah validasi error, update, dll.)
        document.addEventListener('livewire:init', () => {
            Livewire.hook('morph.updated', ({
                el,
                component
            }) => {
                initFlowbite();
            });
        });
    </script>
</body>
