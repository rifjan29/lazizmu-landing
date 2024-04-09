@extends('welcome')
@push('js')
<script>
    let rupiah = `{{ $total_rupiah }}`
    let donatur = `{{ $total_donasi }}`
    let program = `{{ $total_program }}`
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
    animateValueRupiah("total-amount", 0, rupiah, 70000); // Ganti 38041766 dengan jumlah donasi aktual

    animateValue("total_donatur", 0, donatur, 3000); // Ganti 38041766 dengan jumlah donasi aktual
    animateValue("total_program", 0, program, 3000); // Ganti 38041766 dengan jumlah donasi aktual

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
@endpush
@section('content')
<header class="max-w-7xl max-h-fit mx-auto">
    <img src="{{ $banner->gambar != null ? asset('storage/banner/'.$banner->gambar) : 'https://flowbite.com/docs/images/examples/image-2@2x.jpg' }}" class="max-w-xl bg-cover mx-auto rounded-lg" alt="">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-10 p-3 md:p-0 content-center items-start">
        <div class="p-4 space-y-4">
            <h2 class="text-4xl font-bold">Salurkan <span class="text-orange-400">Donasi</span> Anda Disini</h2>
            <p class="text-xl text-gray-400"><b class="text-black">Lazizmu</b> akan selalu siap untuk membantu donasi anda.</p>
            <button type="button" class="text-white bg-orange-400 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-orange-600 dark:hover:bg-orange-700 focus:outline-none dark:focus:ring-orange-800">Donasi Sekarang</button>
        </div>
        <div class="rounded-md border-2 border-orange-300 p-5 h-fit mt-5">
            <div class="grid grid-cols-3 gap-4 content-center">
                <div>
                    <h5 id="total-amount" class="text-2xl font-bold text-orange-600">Rp. 0</h5>
                    <p class="text-sm font-medium text-gray-400">Total Donasi Terkumpul</p>
                </div>
                <div>
                    <h5 id="total_donatur" class="text-2xl font-bold text-orange-600">546</h5>
                    <p class="text-sm font-medium text-gray-400">Donatur Terdaftar</p>
                </div>
                <div>
                    <h5 id="total_program" class="text-2xl font-bold text-orange-600">40</h5>
                    <p class="text-sm font-medium text-gray-400">Program Donasi</p>
                </div>
            </div>
        </div>
    </div>
</header>
{{-- START SECTION DONASI  --}}
<section class="max-w-7xl max-h-fit py-20 mx-auto">
    <div class="p-4 space-y-4 text-center">
        <h2 class="text-4xl font-bold">Program <span class="text-orange-400">Donasi</span> Berjalan</h2>
        <p class="text-xl text-gray-400">Berita terbaru dari <b class="text-black">Lazizmu</b> .</p>
    </div>
    <div class="grid md:grid-cols-3 grid-cols-1 gap-4 content-center pt-16">
        @forelse ($donasi as $item)
            <div class="md:max-w-sm w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <a href="{{ route('frontend.donasi.detail',$item->slug) }}">
                    <img class="rounded-t-lg w-full bg-cover" src="{{ $item->cover != null ? asset('storage/donasi/'.$item->cover) : 'https://flowbite.com/docs/images/examples/image-2@2x.jpg' }}" alt="gambar donasi" />
                </a>
                <div class="p-5">
                    <a href="{{ route('frontend.donasi.detail',$item->slug) }}">
                        <h5 class="text-header">{{ ucwords($item->title) }}</h5>
                    </a>
                    <div class="flex justify-between items-center mb-5 text-gray-500 bg-gray-100 rounded-lg p-3">
                        <span class="bg-emerald-100 text-emerald-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-emerald-200 dark:text-emerald-800">
                            <svg class="mr-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path></svg>
                            {{ ucwords($item->kategori->title ?? "-") }}
                        </span>
                        <span class="text-xs font-sans">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y H:i:s') }}</span>
                    </div>
                    <div>
                        <p class="text-content">{{ $item->sub_content }}.</p>
                    </div>

                </div>
            </div>
        @empty
            <span class="text-center font-bold bg-red-400 text-white p-4">Tidak ada data</span>
        @endforelse


    </div>
</section>
{{-- END SECTION DONASI --}}
{{-- START SECTION PILAR  --}}
<section class="w-full py-8 h-fit mastering-tools relative" style="background-image: url('{{ asset('image/bag-1.jpg') }}');
                                                                        background-repeat: no-repeat;
                                                                        background-attachment: fixed;
                                                                        background-position: center;">
    <div class="p-4 space-y-4 text-center z-10">
        <h2 class="text-4xl font-bold text-white">6 Pilar Program Laziz<span class="text-orange-400">mu</span>.</h2>
        <p class="text-xl text-gray-400">Mari kita dukung program-program yang dilaksanakan oleh <b class="text-black">Lazizmu</b> .</p>
    </div>
    <div class="mastering-tools pb-10 z-10">
        <div class="tools-slideshow">
            <div class="card-animation-right grid grid-cols-1 md:grid-cols-3 gap-10 content-center pt-16 px-5" style="visibility: hidden;" id="slideRight">
                <div class="card hover:border-orange-400 w-full space-y-4 bg-white border border-gray-200 border-l-orange-400 border-l-4 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 p-5">
                    <div class="flex gap-4">
                        <div class="flex align-middle content-center bg-orange-500 text-white p-2 px-4 border rounded-md w-fit h-fit">
                            <h4 class="font-bold text-lg">01</h4>
                        </div>
                        <div class="align-middle self-center">
                            <h2 class="text-2xl font-bold text-orange-500">Pendidikan</h2>
                        </div>
                    </div>
                    <hr>
                    <p class="text-content">
                        Program meningkatkan mutu SDM dengan menjalankan berbagai program dibidang pendidikan berupa pemenuhan sarana dan biaya pendidikan.
                    </p>
                </div>
                <div class="card hover:border-orange-400 w-full space-y-4 bg-white border border-gray-200 border-l-orange-400 border-l-4 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 p-5">
                    <div class="flex gap-4">
                        <div class="flex align-middle content-center bg-orange-500 text-white p-2 px-4 border rounded-md w-fit h-fit">
                            <h4 class="font-bold text-lg">02</h4>
                        </div>
                        <div class="align-middle self-center">
                            <h2 class="text-2xl font-bold text-orange-500">Kesehatan</h2>
                        </div>
                    </div>
                    <hr>
                    <p class="text-content">
                        Program Lazizmu yang berfokus pada pemenuhan hak-hak mustahik untuk mendapatkan kehidupan yang berkualitas melalui layanan kesehatan atau prokes.
                    </p>
                </div>
                <div class="card hover:border-orange-400 w-full space-y-4 bg-white border border-gray-200 border-l-orange-400 border-l-4 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 p-5">
                    <div class="flex gap-4">
                        <div class="flex align-middle content-center bg-orange-500 text-white p-2 px-4 border rounded-md w-fit h-fit">
                            <h4 class="font-bold text-lg">03</h4>
                        </div>
                        <div class="align-middle self-center">
                            <h2 class="text-2xl font-bold text-orange-500">Ekonomi</h2>
                        </div>
                    </div>
                    <hr>
                    <p class="text-content">
                        Program peningkatan kesejahteraan penerima manfaat dana zakat dan donasi lainnya dengan pola pemeberdayaan maupun pelatihan-pelatihan wirausaha.
                    </p>
                </div>
            </div>
            <div class="card-animation-left grid grid-cols-1 md:grid-cols-3 gap-10 content-center pt-16 px-5" id="slideLeft" style="visibility: hidden;">
                <div class="w-full hover:border-orange-400 space-y-4 bg-white border border-gray-200 border-l-orange-400 border-l-4 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 p-5">
                    <div class="flex gap-4">
                        <div class="flex align-middle content-center bg-orange-500 text-white p-2 px-4 border rounded-md w-fit h-fit">
                            <h4 class="font-bold text-lg">04</h4>
                        </div>
                        <div class="align-middle self-center">
                            <h2 class="text-2xl font-bold text-orange-500">Kemanusiaan</h2>
                        </div>
                    </div>
                    <hr>
                    <p class="text-content">
                        Penanganan masalah sosial yang timbul akibat ekses external terhadap kehidupan mustahik, seperti bantuan bencana, bantuan manula dan kegiatan karikatif.
                    </p>
                </div>
                <div class="w-full hover:border-orange-400 space-y-4 bg-white border border-gray-200 border-l-orange-400 border-l-4 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 p-5">
                    <div class="flex gap-4">
                        <div class="flex align-middle content-center bg-orange-500 text-white p-2 px-4 border rounded-md w-fit h-fit">
                            <h4 class="font-bold text-lg">05</h4>
                        </div>
                        <div class="align-middle self-center">
                            <h2 class="text-2xl font-bold text-orange-500">Sosial Dakwah</h2>
                        </div>
                    </div>
                    <hr>
                    <p class="text-content">
                        Pilar yang berfungsi menguatkan sisi ruhani dan pemenuhan kebutuhan untuk kegiatan dakwah dengan tujuan kemandirian para da’i dan institusi dakwah.
                    </p>
                </div>
                <div class="w-full hover:border-orange-400 space-y-4 bg-white border border-gray-200 border-l-orange-400 border-l-4 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 p-5">
                    <div class="flex gap-4">
                        <div class="flex align-middle content-center bg-orange-500 text-white p-2 px-4 border rounded-md w-fit h-fit">
                            <h4 class="font-bold text-lg">06</h4>
                        </div>
                        <div class="align-middle self-center">
                            <h2 class="text-2xl font-bold text-orange-500">Lingkungan</h2>
                        </div>
                    </div>
                    <hr>
                    <p class="text-content">
                        Sumbangsih Lazismu untuk peningkatan kualitas lingkungan bagi kehidupan masyarakat dan ekosistem yang lebih baik sehingga bisa menjaga keseimbangan alam.
                    </p>
                </div>
            </div>
        </div>
    </div>

</section>
{{-- END SECTION PILAR --}}
{{-- START SECTION Informasi --}}
<section class="max-w-7xl max-h-fit py-20 mx-auto">
    <div class="p-4 space-y-4 text-center">
        <h2 class="text-4xl font-bold">Informasi terkini Laziz<span class="text-orange-400">mu</span></h2>
        <p class="text-xl text-gray-400">Berita terbaru dari <b class="text-black">Lazizmu</b> .</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 content-center pt-16 px-4 md:px-0">
        @forelse ($berita as $item)
        <div class="w-full md:max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <a href="{{ route('frontend.berita.detail',$item->slug) }}">
                <img class="rounded-t-lg w-full bg-cover" src="{{ $item->cover != null ? asset('storage/cover/'.$item->cover) : 'https://flowbite.com/docs/images/examples/image-2@2x.jpg' }}" alt="" />
            </a>
            <div class="p-5">
                <div class="flex justify-between items-center mb-5 text-gray-500 border-b-2 p-3">
                    <span class="bg-emerald-100 text-emerald-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-emerald-200 dark:text-emerald-800">
                        <svg class="mr-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path></svg>
                        {{ ucwords($item->kategori->title ??  '-') }}
                    </span>
                    <span class="text-xs font-sans">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y H:i:s') }}</span>
                </div>
                <a href="{{ route('frontend.berita.detail',$item->slug) }}">
                    <h5 class="text-header">{{ ucwords($item->title) }}</h5>
                </a>
                <div class="mt-4 text-content">
                   {{ $item->sub_content }}
                </div>
                <div class="flex justify-end mt-4">
                    <a href="{{ route('frontend.berita.detail',$item->slug) }}" class="inline-flex items-center text-yellow-400 hover:text-yellow-600 cursor-pointer focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-yellow-300 dark:text-yellow-300 dark:hover:text-white dark:hover:bg-yellow-400 dark:focus:ring-yellow-900">
                        Lanjutkan Membaca
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @empty
            <span class="text-center font-bold bg-red-400 text-white p-4">Tidak ada data</span>
        @endforelse

    </div>
    <div class="flex justify-center mt-4">
        <a type="button" href="{{ route('berita.index') }}" class="inline-flex items-center text-yellow-400 hover:text-white border border-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-yellow-300 dark:text-yellow-300 dark:hover:text-white dark:hover:bg-yellow-400 dark:focus:ring-yellow-900">
            Informasi Selengkapnya
            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
            </svg>
        </a>
    </div>
</section>
<div class="py-14">
    <div class="relative w-full h-full py-24" style="background-image: url('{{ asset('image/bag-1.jpg') }}');">
        <div class="absolute inset-0 bg-gradient-to-t from-transparent to-black opacity-25"></div>
        <div class="text-center text-white h-full flex flex-col justify-center ">
            <h1 class="text-4xl font-bold mb-4 z-50">Donasi Sekarang</h1>
            <p class="text-lg z-50 italic">Jika kalian berbuat baik, sesungguhnya kalian berbuat baik bagi diri kalian sendiri” (QS. Al-Isra:7)</p>
        </div>
        <div class="absolute inset-0" style="background-image: url('{{ asset('image/bag-1.jpg') }}'); background-attachment: fixed; background-size: cover; background-position: center;"></div>
    </div>
</div>
{{-- END SECTION Informasi --}}
{{-- START SECTION GALERI --}}
<section class="max-w-7xl max-h-fit py-20 mx-auto">
    <div class="p-4 space-y-5 text-center mb-5">
        <h2 class="text-4xl font-bold">Dokumentasi kegiatan</h2>
        <p class="text-xl text-gray-400">Berita terbaru dari <b class="text-black">Lazizmu</b> .</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-10 p-4 md:p-0">
        @forelse ($galeri as $item)
        <div>
            <figure class="relative max-w-fit transition-all duration-300 cursor-pointer filter grayscale hover:grayscale-0">
                <img class="max-h-full max-w-full rounded-lg" src="{{ $item->galeri != null ? asset('storage/galeri/'.$item->galeri) : 'https://flowbite.com/docs/images/examples/image-2@2x.jpg' }}" alt="image description">
                <figcaption class="absolute px-4 text-gray-100 dark:text-white bottom-0 bg-orange-950 h-fit p-4 w-full rounded-lg">
                    <p class="z-50 font-semibold text-sm md:text-clip">{{ ucwords($item->keterangan) }}</p>
                    <hr>
                    <div class="flex justify-end">
                        <span class="font-sans text-xs md:text-clip">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</span>
                    </div>
                </figcaption>
            </figure>
        </div>
        @empty
        <span class="text-center font-bold bg-red-400 text-white p-4">Tidak ada data</span>
        @endforelse

    </div>
</section>
{{-- END SECTION GALERI --}}
@endsection
