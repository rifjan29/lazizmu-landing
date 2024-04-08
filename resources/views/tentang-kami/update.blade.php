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
            <div class="grid grid-cols-2">
                <div  class="w-full mx-auto space-y-6">
                    <div class="bg-white rounded-lg shadow m-4 dark:bg-gray-800 p-5">
                        <article class="mx-auto w-full format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                            <img class="max-h-96 w-1/2 mx-auto transition-all duration-300 rounded-lg cursor-pointer filter grayscale hover:grayscale-0" src="{{ $data->cover != null ? asset('storage/cover/'.$data->cover) : 'https://flowbite.com/docs/images/examples/image-2@2x.jpg' }}" alt="image description">
                            <header class="mb-4 lg:mb-6 not-format">
                                <span class="my-3 inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ ucwords($data->kategori->title) }}</span>
                                <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">{{ ucwords($data->title) }}</h1>
                                <address class="flex items-center mb-6 not-italic">
                                    <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                                        <div class="flex flex-nowrap">
                                            <div class="flex flex-nowrap pr-3">
                                                <svg class="w-4 h-4 mx-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 11 14H9a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 10 19Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                </svg>
                                                <p rel="author" class="text-sm font-bold text-gray-900 dark:text-white">{{ ucwords($data->user->name) }}</p>
                                            </div>
                                            <div class="flex flex-nowrap px-3">
                                                <svg class="w-4 h-4 mx-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M10 6v4l3.276 3.276M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                                <p rel="author" class="text-sm font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </address>
                            </header>
                            <p class="lead">
                                {!! $data->content !!}
                            </p>
                        </article>
                    </div>

                </div>
                <div>
                    <div  class="w-full mx-auto space-y-6">
                        <div class="bg-white rounded-lg shadow m-4 dark:bg-gray-800 p-5">
                            <h4 class="font-bold mb-3">Update Status</h4>
                            <hr>
                            <form action="{{ route('informasi.updatePost') }}" class="mt-5" method="POST">
                            @csrf
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <div class="grid gap-4 grid-cols-2 sm:grid-cols-2 sm:gap-6 mb-5">
                                    <div class="col-span-2 sm:col-span-2">
                                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Kategori</label>
                                        <select name="kategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="">
                                            <option value="0">Pilih Status</option>
                                            <option value="publis">Dipublis</option>
                                            <option value="ditolak">Ditolak</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="mt-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300
                                        font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Simpan
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
