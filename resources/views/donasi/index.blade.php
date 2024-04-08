<x-app-layout>
    @push('css')
        <style>
            .justify-self-end  {
                justify-content: end
            }
        </style>
    @endpush
    @include('donasi.modal.update-donasi')
    @push('js')
        <script>
              // show
              $('.update-donasi').on('click',function() {
                let id = $(this).data('id');
                $.ajax({
                    url: `{{ route('donasi.updateDonasiDetail', 1) }}`,
                    data: {
                        id: id
                    },
                    method: "GET",
                    success: (res) => {
                        console.log(res);
                        // Assuming you have a modal with an ID 'show-modal'
                        $('#update-modal #id').val(res.id);
                        $('#update-modal #total_donasi').val(formatRupiah(res.total_dana));
                        $('#update-modal #total_donatur').val(res.total_donatur);
                        $('#update-modal #status').val(res.status_donasi);

                        // Show the modal
                        $('#update-modal').removeClass('hidden');

                    }
                })
                function formatRupiah(angka) {
                    let cleaned = angka.replace(/\D/g, ""); // Bersihkan dari non-digit
                    let length = cleaned.length;

                    // Jika panjang angka lebih dari 2, lakukan pemisahan dengan titik setiap 3 digit
                    if (length > 2) {
                        let integerPart = cleaned.substring(0, length - 2);
                        let decimalPart = cleaned.substring(length - 2, length);

                        integerPart = integerPart.split("").reverse().join("")
                            .match(/.{1,3}/g)
                            .join(".")
                            .split("").reverse().join("");

                        return `${integerPart}`;
                    } else {
                        // Jika panjang angka kurang dari atau sama dengan 2, anggap sebagai bagian desimal saja
                        return cleaned;
                    }
                }
                var total_donasi = document.getElementById("total_donasi");
                total_donasi.value = formatRupiah(total_donasi.value);
                total_donasi.addEventListener("keyup", function(e) {
                    total_donasi.value = formatRupiah(this.value);
                });
            })
        </script>
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
                   <div class="mb-3 flex justify-end">
                        <a href="{{ route('donasi.create') }}"  class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Tambah Donasi
                        </a>
                   </div>
                    <hr>
                    <div class="overflow-x-auto w-full mt-5">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="datatable">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">No</th>
                                    <th scope="col" class="px-4 py-3">Gambar</th>
                                    <th scope="col" class="px-4 py-3">Judul</th>
                                    <th scope="col" class="px-4 py-3">Kategori</th>
                                    <th scope="col" class="px-4 py-3">Total Donasi</th>
                                    <th scope="col" class="px-4 py-3">Total Donatur</th>
                                    <th scope="col" class="px-4 py-3">Status</th>
                                    <th scope="col" class="px-4 py-3">Status Donasi</th>
                                    <th scope="col" class="px-4 py-3">Tanggal</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <img class="h-auto max-w-12 rounded-lg" src="{{ $item->cover != null ? asset('storage/donasi/'.$item->cover) : 'https://flowbite.com/docs/images/examples/image-2@2x.jpg' }}" alt="image description">
                                        </th>
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ ucwords($item->title) }}</th>
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ ucwords($item->kategori->title ?? "-") }}</th>
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">Rp. {{ number_format($item->total_dana, 2, ',', '.') }}</th>
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $item->total_donatur }} Donatur</th>
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            @role('admin')
                                                @if ($item->status == 'pending')
                                                    <span class="text-yellow-400 font-semibold">
                                                        {{ ucwords($item->status) }}
                                                    </span>
                                                @elseif ($item->status == 'publis')
                                                    <span class="text-blue-400 font-semibold">
                                                        {{ ucwords($item->status) }}
                                                    </span>
                                                @else
                                                    <span class="text-red-400 font-semibold">
                                                        {{ ucwords($item->status) }}
                                                    </span>
                                                @endif
                                            @elserole('super-admin')
                                                @if ($item->status == 'pending')
                                                    <a href="{{ route('donasi.updateDetail',$item->id) }}" class="underline hover:text-yellow-400 font-semibold">
                                                        {{ ucwords($item->status) }}
                                                    </a>
                                                @elseif ($item->status == 'publis')
                                                    <span class="text-blue-400 font-semibold">
                                                        {{ ucwords($item->status) }}
                                                    </span>
                                                @else
                                                    <span class="text-red-400 font-semibold">
                                                        {{ ucwords($item->status) }}
                                                    </span>
                                                @endif
                                            @endrole
                                        </th>
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            @role('admin')
                                                @if ($item->status_donasi == 'berjalan')
                                                    <span class="text-blue-400 font-semibold">
                                                        {{ ucwords($item->status_donasi) }}
                                                    </span>
                                                @else
                                                    <span class="text-red-400 font-semibold">
                                                        {{ ucwords($item->status_donasi) }}
                                                    </span>
                                                @endif
                                            @elserole('super-admin')
                                                @if ($item->status_donasi == 'berjalan')
                                                    <a data-modal-target="update-modal" data-modal-toggle="update-modal" data-id="{{ $item->id }}"  class="update-donasi cursor-pointer underline text-blue-700 hover:text-blue-400 font-semibold">
                                                        {{ ucwords($item->status_donasi) }}
                                                    </a>
                                                @else
                                                    <span class="text-red-400 font-semibold">
                                                        {{ ucwords($item->status_donasi) }}
                                                    </span>
                                                @endif
                                            @endrole
                                        </th>
                                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</td>
                                        <td class="px-4 py-3 flex items-center justify-end">
                                            <button id="{{ $item->id }}-button" data-dropdown-toggle="{{ $item->id }}-dropdown" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                            <div id="{{ $item->id }}-dropdown" class="hidden z-50 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="{{ $item->id }}-button">
                                                    <li>
                                                        <a href="{{ route('donasi.show',$item->id) }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white show-data">Show</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('donasi.edit',$item->id) }}" data-modal-target="edit-modal" data-modal-toggle="edit-modal" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white edit-data">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('donasi.destroy', $item->id) }}" data-confirm-delete="true" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                                                    </li>
                                                </ul>
                                                <div class="py-1">

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
