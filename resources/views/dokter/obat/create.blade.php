create

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
                                {{ __('Tambah Data Obat') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Silakan isi form di bawah ini untuk menambahkan data obat ke dalam sistem.') }}
                            </p>
                            @if (session('alert'))
                                <div class="mb-4 alert alert-success">
                                    {{ session('alert') }}
                                </div>
                            @endif
                        </header>

                        <form class="mt-6" id="formObat" action="{{ route('dokter.obat.store') }}" method="POST">
                            @csrf
                            <div class="mb-3 form-group">
                                <label for="namaObat">Nama Obat</label>
                                <input type="text"
                                    class="rounded form-control @error('nama_obat') is-invalid @enderror" id="namaObat"
                                    name="nama_obat" value="{{ old('nama_obat') }}">
                                @error('nama_obat')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 form-group">
                                <label for="kemasan">Kemasan</label>
                                <input type="text"
                                    class="rounded form-control @error('kemasan') is-invalid @enderror" id="kemasan"
                                    name="kemasan" value="{{ old('kemasan') }}">
                                @error('kemasan')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 form-group">
                                <label for="harga">Harga</label>
                                <input type="text" class="rounded form-control @error('harga') is-invalid @enderror"
                                    id="harga" name="harga" value="{{ old('harga') }}">
                                @error('harga')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <a type="button" href="{{ route('dokter.obat.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
