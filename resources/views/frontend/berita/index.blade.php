@extends('welcome')

@section('content')
    <section class="max-w-7xl max-h-fit py-20 mx-auto">
        <div class="p-4 space-y-4 text-center mb-5">
            <h2 class="text-4xl font-bold">Berita terkini</h2>
            <p class="text-xl text-gray-400">Mari kita dukung program-program yang dilaksanakan oleh <b class="text-black">Lazizmu</b> .</p>
        </div>
        <form class="max-w-6xl mx-auto" method="GET" action="{{ route('frontend.berita.index') }}">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search"  value="{{ request('search') }}" name="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Masukkan kata kunci..." />
                <a href="{{ route('frontend.berita.index') }}" class="text-white absolute right-24 bottom-2.5 bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Reset</a>
                <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
            </div>
        </form>
        <div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 content-center pt-16 px-4 md:px-0">
                @forelse ($berita as $item)
                    <div class="w-full md:max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <a href="{{ route('frontend.berita.detail',$item->slug) }}">
                            <img class="rounded-t-lg w-full bg-cover" src="{{ $item->cover != null ? asset('storage/cover/'.$item->cover) : 'https://flowbite.com/docs/images/examples/image-2@2x.jpg' }}" alt="{{ $item->title }}" />
                        </a>
                        <div class="p-5">
                            <div class="flex justify-between items-center mb-5 text-gray-500 border-b-2 p-3">
                                <span class="bg-emerald-100 text-emerald-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-emerald-200 dark:text-emerald-800">
                                    <svg class="mr-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path></svg>
                                    {{ ucwords($item->kategori->title ??  '-') }}
                                </span>
                                <span class="text-xs font-sans">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y H:i:s') }}</span>
                            </div>
                            <a href="#">
                                <h5 class="text-header">{{ ucwords($item->title) }}</h5>
                            </a>
                            <div class="mt-4">
                                <p class="text-content">
                                    {{ $item->sub_content }}
                                </p>
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
                <span class=" col-span-3 text-center w-full font-bold bg-red-400 text-white p-4">Tidak ada data</span>
                @endforelse
            </div>
        </div>
        <div class="mt-5">
            <hr class="mb-4">
            {{ $berita->links() }}
        </div>
    </section>
@endsection
