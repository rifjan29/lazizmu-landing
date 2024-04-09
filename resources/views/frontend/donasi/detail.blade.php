@extends('welcome')
@section('content')
    <section class="py-40 md:pb-48 md:px-80 max-h-fit ">
        <div class="p-4 space-y-4 text-center mb-5 ">
            {{-- <p class="text-center font-bold text-orange-600">Marwah Salsabilah</p> --}}
            <h2 class="text-4xl font-bold text-orange-400">{{ ucwords($data->title) }}</h2>
            <div class="flex justify-center gap-20 text-gray-500 text-sm">
                <div class="inline-flex items-center">
                    <div>
                        <svg class="w-5 h-5 text-gray-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M7 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h1m4-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm7.441 1.559a1.907 1.907 0 0 1 0 2.698l-6.069 6.069L10 19l.674-3.372 6.07-6.07a1.907 1.907 0 0 1 2.697 0Z"/>
                          </svg>
                    </div>
                    <div class="ml-2">
                        <span>{{ ucwords($data->user->name) }}</span>
                    </div>
                </div>
                <div class="inline-flex items-center">
                    <div>
                        <svg class="w-5 h-5 text-gray-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z"/>
                          </svg>

                    </div>
                    <div class="ml-2">
                        <span>{{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y H:i:s') }}</span>
                    </div>
                </div>
            </div>
            {{-- <p class="text-md text-gray-400">Diupload pada tanggal 14 Maret 2024.</p> --}}
        </div>
        <img src="{{ $data->cover != null ? asset('storage/donasi/'.$data->cover) : 'https://flowbite.com/docs/images/examples/image-2@2x.jpg' }}" class="h-auto max-w-full rounded-lg mx-auto" alt="gambar donasi">

        <div class="md:p-10 p-4 text-content">
            <div class="grid grid-cols-8 gap-4">
                <div class="col-span-5">
                    <div class="mb-4">
                        <h2 class="text-2xl font-bold text-black">Deskripsi</h2>
                        <hr class="h-1 bg-orange-400 w-24">
                    </div>
                    {!! $data->content !!}
                </div>
                <div class="col-span-3">
                    <div class="mb-4 p-4 bg-orange-50 rounded-lg">
                        <div class="mb-4 space-y-2">
                            <span class="text-xs">Diupload pada tanggal {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}</span>
                            <h4 class="text-lg font-bold text-orange-400">{{ ucwords($data->title) }}</h4>
                            <hr>
                        </div>
                        <div class="flex flex-col mb-4 space-y-2">
                            <span class="text-xs font-bold">Total dana terkumpul</span>
                            <div class="inline-flex items-center justify-between  py-0.5">
                                <h5 id="total-amount" class="text-2xl font-bold text-orange-600">Rp. {{ number_format($data->total_dana,2, ",", ".") }}</h5>
                                <span class="text-xs font-bold">{{ $data->total_donatur }} Donatur</span>
                            </div>
                            <hr>
                        </div>
                        <div>
                            <a href="https://wa.me/628123456789" target="_blank" class="text-white w-full cursor-pointer bg-orange-400 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-orange-600 dark:hover:bg-orange-700 focus:outline-none dark:focus:ring-orange-800">Donasi Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
