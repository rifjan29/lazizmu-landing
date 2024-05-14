@extends('welcome')

@section('content')
    <section class="max-w-7xl max-h-fit py-20 mx-auto">
        <div class="p-4 space-y-4 text-center mb-5">
            <h2 class="text-4xl font-bold">{{ ucwords($title) }}</h2>
            <hr class="h-1 bg-orange-400 w-24 mx-auto">
        </div>
        <div class="bg-white rounded-lg shadow-gray-200 shadow-md p-10 h-fit">
            <div class="mb-5">
                <img class="h-auto max-full rounded-lg mx-auto shadow-md" src="{{ $data->gambar != null ? asset('storage/tentang/'.$data->gambar) : 'https://flowbite.com/docs/images/examples/image-2@2x.jpg' }}" alt="image description">
            </div>
            <hr>
            <div class="p-4 space-y-4 text-center mb-5">
                <h2 class="text-4xl font-bold">List Kepengurusan</h2>
                <hr class="h-1 bg-orange-400 w-24 mx-auto">
            </div>
            <div class="grid grid-cols-3 gap-4 mt-5">
                @forelse ($pengurus as $item)
                    <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <img class="p-8 rounded-t-lg mx-auto" src="{{ $item->gambar != null ? asset('storage/pengurus/'.$item->gambar) : 'https://flowbite.com/docs/images/examples/image-2@2x.jpg' }}" alt="product image" />
                        <div class="px-5 pb-5">
                            <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white text-center">{{ ucwords($item->nama) }}</h5>
                            <div class="flex justify-center mt-2.5 mb-5">
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">Jabatan : {{ $item->jabatan }}</span>
                            </div>

                        </div>
                    </div>
                @empty
                    <span>Tidak ada data</span>
                @endforelse
            </div>

        </div>
    </section>
@endsection
