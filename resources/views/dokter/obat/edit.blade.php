<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Obat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Edit Data Obat') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Silakan perbarui informasi obat sesuai dengan nama, kemasan, dan harga terbaru.') }}
                            </p>
                            @if (session('alert'))
                                <div class="mb-4 alert alert-success">
                                    {{ session('alert') }}
                                </div>
                            @endif
                        </header>

                        <form class="mt-6" action="{{ route('dokter.obat.update', $obat->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3 form-group">
                                <label for="editNamaObatInput">Nama</label>
                                <input type="text" class="rounded form-control" id="editNamaObatInput"
                                    value="{{ old('nama_obat', $obat->nama_obat) }}" name="nama_obat">
                                @error('nama_obat')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-group">
                                <label for="editKemasanInput">Kemasan</label>
                                <input type="text" class="rounded form-control" id="editKemasanInput"
                                    value="{{ old('kemasan', $obat->kemasan) }}" name="kemasan">
                                @error('kemasan')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-group">
                                <label for="editHargaInput">Harga</label>
                                <input type="text" class="rounded form-control" id="editHargaInput"
                                    value="{{ old('harga', $obat->harga) }}" name="harga">
                                @error('harga')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>

                            <a type="button" href="{{ route('dokter.obat.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
