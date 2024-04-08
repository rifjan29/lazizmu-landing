<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('css')
        <style>
            /* width */
            ::-webkit-scrollbar {
                width: 10px;
            }

            /* Track */
            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            /* Handle */
            ::-webkit-scrollbar-thumb {
                background: #FF8A4C;
            }

            /* Handle on hover */
            ::-webkit-scrollbar-thumb:hover {
                background: #555;
            }
        </style>
        <link rel="stylesheet" href="{{ asset('js/animations.css') }}">
    </head>
    <body class="antialiased bg-gray-50 h-screen ">
        @include('layouts.frontend.navigation')
        <div class="content-wrapper"    >
            @yield('content')
        </div>
        <div class="fixed bottom-8 right-8 ">
            <a href="https://wa.me/628123456789" target="_blank" rel="noopener noreferrer" class="bg-green-500 hover:bg-green-600 text-white rounded-full py-4 px-8 shadow-lg flex items-center justify-center gap-2">
                @include('components.whatsapp')
                <span>Hubungi Kami</span>
            </a>
        </div>
        @include('layouts.frontend.footer')
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function animateValueRupiah(id, start, end, duration) {
            var obj = document.getElementById(id);
            var range = end - start;
            var current = start;
            var increment = end > start ? 1 : -1;
            var stepTime = Math.abs(Math.floor(duration / range));
            var timer = setInterval(function () {
                current += increment;
                obj.textContent = "Rp. " + current.toLocaleString('id-ID'); // Format jumlah dengan pemisah ribuan
                if (current == end) {
                    clearInterval(timer);
                }
            }, stepTime);
        }
        function animateValue(id, start, end, duration) {
            var obj = document.getElementById(id);
            var range = end - start;
            var current = start;
            var increment = end > start ? 1 : -1;
            var stepTime = Math.abs(Math.floor(duration / range));
            var timer = setInterval(function () {
                current += increment;
                obj.textContent = current; // Format jumlah dengan pemisah ribuan
                if (current == end) {
                    clearInterval(timer);
                }
            }, stepTime);
        }

        // Panggil fungsi animateValue dengan nilai awal dan akhir
        animateValueRupiah("total-amount", 0, 38041766, 3000); // Ganti 38041766 dengan jumlah donasi aktual

        animateValue("total_donatur", 0, 200, 3000); // Ganti 38041766 dengan jumlah donasi aktual
        animateValue("total_program", 0, 200, 3000); // Ganti 38041766 dengan jumlah donasi aktual

    </script>
    <script>
        $(window).scroll(function() {
            $('#slideRight').each(function(){
            var imagePos = $(this).offset().top;
            console.log(imagePos);
            var topOfWindow = $(window).scrollTop();
                if (imagePos < topOfWindow+400) {
                    $(this).addClass("slideRight");
                }
            });
            $('#slideLeft').each(function(){
            var imagePos = $(this).offset().top;
            console.log(imagePos);
            var topOfWindow = $(window).scrollTop();
                if (imagePos < topOfWindow+400) {
                    $(this).addClass("slideLeft");
                }
            });

        });
    </script>
    @stack('js')
</html>
