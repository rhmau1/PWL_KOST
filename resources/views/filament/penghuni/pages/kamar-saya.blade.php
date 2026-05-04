<x-filament::page>

    @if ($kamar)
        <div class="p-6 bg-gray-900 rounded-xl shadow space-y-4">

            {{-- Nama Kos --}}
            <h2 class="text-2xl font-bold">
                {{ $kamar->kos->nama_kos ?? '-' }}
            </h2>

            {{-- Nomor Kamar --}}
            <p class="text-gray-300">
                <strong>Nomor Kamar:</strong> {{ $kamar->nomor }}
            </p>

            {{-- Jenis --}}
            <p class="text-gray-300">
                <strong>Jenis:</strong> {{ $kamar->jenis }}
            </p>

            {{-- Harga --}}
            <p class="text-lg font-semibold text-primary-500">
                Rp {{ number_format($kamar->harga) }} / bulan
            </p>

            {{-- Status --}}
            <p>
                <strong>Status:</strong>
                <span class="px-2 py-1 bg-green-600 text-white rounded">
                    Terisi
                </span>
            </p>

            {{-- Fasilitas --}}
            <div>
                <p class="font-semibold">Fasilitas:</p>

                @if(is_array($kamar->fasilitas))
                    <ul class="list-disc ml-5 text-gray-400">
                        @foreach($kamar->fasilitas as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-400">{{ $kamar->fasilitas ?? '-' }}</p>
                @endif
            </div>

            {{-- Keterangan --}}
            <div>
                <p class="font-semibold">Keterangan:</p>
                <p class="text-gray-400">
                    {{ $kamar->keterangan ?? '-' }}
                </p>
            </div>

        </div>
    @else
        <div class="p-6 text-center bg-gray-900 rounded-xl">
            <p class="text-gray-400">
                Anda belum memiliki kamar
            </p>
        </div>
    @endif

</x-filament::page>