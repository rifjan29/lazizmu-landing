<x-app-layout>
    @push('css')
        <style>
            .justify-self-end  {
                justify-content: end
            }
        </style>
    @endpush
    <div class="p-4 sm:ml-64">
        <div class="flex justify-between mt-20 p-4">
            <div>
                <h5 class="font-bold text-lg dark:text-white">{{ $title }}</h5>
            </div>
            <div>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                            </svg>
                                Dashboard
                            </a>
                        </li>

                        <li aria-current="page">
                            <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">{{ ucwords($title) }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="p-4">
            <div  class="w-full mx-auto space-y-6">
                <div class="bg-white rounded-lg shadow m-4 dark:bg-gray-800 p-5">
                    <article class="mx-auto w-full format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                        <img class="max-h-96 w-1/2 mx-auto transition-all duration-300 rounded-lg cursor-pointer filter grayscale hover:grayscale-0" src="{{ $data->gambar != null ? asset('storage/tentang/'.$data->gambar) : 'https://flowbite.com/docs/images/examples/image-2@2x.jpg' }}" alt="image description">
                        <div class="py-5">
                            <h4 class="font-bold text-lg ">Latar Belakang</h4>
                            <p class="text-gray-500 dark:text-gray-400">{!! $data->latar_belakang !!}</p>
                            <hr>
                        </div>
                        <div class="py-5">
                            <h4 class="font-bold text-lg ">Visi</h4>
                            <p class="text-gray-500 dark:text-gray-400">{!! $data->visi !!}</p>
                            <hr>
                        </div>
                        <div class="py-5">
                            <h4 class="font-bold text-lg ">Misi</h4>
                            <p class="text-gray-500 dark:text-gray-400">{!! $data->misi !!}</p>
                            <hr>
                        </div>
                        <div class="py-5">
                            <h4 class="font-bold text-lg ">Prinsip</h4>
                            <p class="text-gray-500 dark:text-gray-400">{!! $data->prinsip !!}</p>
                            <hr>
                        </div>
                    </article>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
