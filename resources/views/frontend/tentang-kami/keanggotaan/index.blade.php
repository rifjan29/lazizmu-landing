@extends('welcome')

@section('content')
    <section class="max-w-7xl max-h-fit py-20 mx-auto">
        <div class="p-4 space-y-4 text-center mb-5">
            <h2 class="text-4xl font-bold">{{ ucwords($title) }}</h2>
            <hr class="h-1 bg-orange-400 w-24 mx-auto">
        </div>
        <div class="bg-white rounded-lg shadow-gray-200 shadow-md p-10 h-fit">
            <div class="">
                <img class="h-auto max-full rounded-lg mx-auto shadow-md" src="{{ $data->gambar != null ? asset('storage/tentang/'.$data->gambar) : 'https://flowbite.com/docs/images/examples/image-2@2x.jpg' }}" alt="image description">

            </div>

        </div>
    </section>
@endsection
