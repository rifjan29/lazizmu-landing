@extends('welcome')

@section('content')
    <section class="max-w-7xl max-h-fit py-20 mx-auto">
        <div class="p-4 space-y-4 text-center mb-5">
            <h2 class="text-4xl font-bold">{{ $title }}</h2>
            <hr class="h-1 bg-orange-400 w-24 mx-auto">
        </div>
        <div class="bg-white rounded-lg shadow-gray-200 shadow-md p-10 h-fit space-y-4">
            <div class="w-8">
                <h4 class="font-bold text-lg text-orange-700">Visi</h4>
                <hr class="h-1 bg-orange-300">
            </div>
            <div class="text-content">
                {!! $data->visi !!}
            </div>
            <div class="w-8">
                <h4 class="font-bold text-lg text-orange-700">Misi</h4>
                <hr class="h-1 bg-orange-300">
            </div>
            <div class="text-content">
                {!! $data->misi !!}
            </div>
            <div class="w-14">
                <h4 class="font-bold text-lg text-orange-700">Prinsip</h4>
                <hr class="h-1 bg-orange-300">
            </div>
            <div class="text-content">
                {!! $data->prinsip !!}
            </div>
            <div class="w-16">
                <h4 class="font-bold text-lg text-orange-700">Tujuan</h4>
                <hr class="h-1 bg-orange-300">
            </div>
            <div class="text-content">
                <span class="font-bold ">Pengelolaan dana ZISKA bertujuan :</span>
                {!! $data->tujuan !!}
            </div>


        </div>
    </section>
@endsection
