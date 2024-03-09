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
            <div class="mx-auto max-w-full h-full">
                <!-- Start coding here -->
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-visible h-full z-0 p-4">
                    <form action="{{ route('donasi.update',$data->id) }}" method="POST" class="w-full mx-auto" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="grid gap-4 grid-cols-2 sm:grid-cols-2 sm:gap-6 mb-5">
                        <div class="col-span-2 sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul</label>
                            <input type="text" name="title" value="{{ old('title',$data->title) }}" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukkan nama">
                        </div>
                        <div class="col-span-2 sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Kategori</label>
                            <select name="kategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="">
                                <option value="0">Pilih Status</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}" {{ old('title',$data->kategori_id) == $item->id ? 'selected' : '' }}>{{ ucwords($item->title) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2 sm:col-span-2">
                            <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sub Konten</label>
                            <textarea
                                    name="sub_content"
                                    rows="8"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Masukkan sub content">{{ old('sub_content',$data->sub_content) }}</textarea>
                        </div>
                        <div class="col-span-2 sm:col-span-2">
                            <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Content</label>
                            <textarea  id="summernote"
                                    name="content"
                                    rows="8"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Masukkan content">{!! old('content',$data->content) !!}</textarea>
                        </div>
                        <div class="col-span-2 sm:col-span-2">
                            <label for="wali_santri" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cover</label>
                            <img id="foto_santri" src="{{ $data->cover != null ? asset('storage/donasi/'.$data->cover) : 'https://flowbite.com/docs/images/examples/image-2@2x.jpg' }}" class="h-auto max-w-xs rounded-lg" alt="">
                        </div>
                        <div class="col-span-2 sm:col-span-2">
                            <label for="wali_santri" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cover</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help"
                                    id="file_input"
                                    type="file"
                                    name="file_input">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
                        </div>
                    </div>
                    <hr>
                    <button type="submit"
                        class="mt-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300
                            font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Simpan
                    </button>
                    <button type="reset" class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white
                    dark:hover:bg-gray-600 dark:focus:ring-gray-600">Reset</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
